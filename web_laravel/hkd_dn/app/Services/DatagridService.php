<?php

namespace App\Services;
use DB;

class DatagridService
{
    protected $modelNS;

    public function __construct($modelNS)
    {
        $this->modelNS = $modelNS;
    }

    private function getQuery($data){
        $retStr = "";
        $isNestedArr = false;
        foreach($data as $k2 => $f2) {
            if(is_array($f2)){
                $isNestedArr = true;
                break;
            }
        }
        if(!$isNestedArr && count($data) == 3){
            if($data[1] == 'contains') {
                return "LOWER($data[0]) like binary LOWER(N'%$data[2]%')";
            }
            if($data[1] == 'startswith') {
                return "LOWER($data[0]) like binary LOWER(N'$data[2]%')";
            }
            if($data[1] == 'endswith') {
                return "LOWER($data[0]) like binary LOWER(N'%$data[2]')";
            }
            if($data[1] == 'notcontains') {
                return "LOWER($data[0]) NOT like binary LOWER(N'%$data[2]%')";
            }
            return "$data[0] $data[1] N'$data[2]'";
        }
    
        foreach($data as $k2 => $f2) {
            if(is_array($f2)){
                $retStr .= "(".$this->getQuery($f2).")";
            }else{
                $retStr .= " $f2 ";
            }
        }
        return $retStr;
    }

    public function invoke($request, $relatedAlias = null) {
        $res['info'] = [];
        $res['info']['request'] = $request->all();
        $data = $this->modelNS;

        $filter = [];
        if($request->searchExpr && $request->searchOperation && $request->searchValue) {
            $filter = [json_decode($request->searchExpr), 'contains',json_decode($request->searchValue)];
        }
        if($request->filter) {
            $filter = json_decode($request->filter);
        }
        if(count($filter) > 0){
            $data = $data->whereRaw($this->getQuery($filter));
        }

        // TODO : cek logic untuk yang custom summary
        if($request->totalSummary) {
            $res['summary'] = [];
            $summaries = json_decode($request->totalSummary);

            foreach($summaries as $summary) {
                $cmd = $summary->summaryType;
                array_push($res['summary'], $data->$cmd($summary->selector));
            }
        }

        if($request->requireTotalCount == 'true') {
            $res['totalCount'] = $data->count();
        }

        if($request->group) {
            $resData = [];
            $groups = json_decode($request->group);

            // TODO : cek lagi apakah group selalu array count = 1 atau bisa lebih dari 1 sehingga butuh foreach
            $res['info']['sql'] = $data->toSql();

            if($groups[0]->isExpanded == 'true') {
                //Trường hợp nếu lấy dữ liệu thì lấy tất bản ghi
                $gData0 = $data->get();
            } else {
                //Trường hợp chỉ lọc lấy các trường group
                $gData0 = $data->select($groups[0]->selector)->distinct()->get();
            }

            $gData0 = $gData0->groupBy($groups[0]->selector);

            if($request->requireGroupCount == 'true') {
                $res['groupCount'] = $gData0->count();
            }

            if(isset($groups[0]->desc)) {
                if($groups[0]->desc) {
                    $gData0 = $gData0->sortByDesc($groups[0]->selector);
                } else {
                    $gData0 = $gData0->sortBy($groups[0]->selector);
                }
            }

            // group inner data
            $gSelector = $groups[0]->selector;
            if($request->related) {
                if(isset($request->related[$gSelector])) {
                    $gSelector = $request->related[$gSelector];
                }
            }

            $i = 0;
            foreach($gData0 as $key => $item) {
                $resData[$i] = [];
                $resData[$i]['key'] = $key;

                if($request->sort) {
                    $sorts = json_decode($request->sort);

                    // data yang di group by kemudian di sort, array sort-nya bisa lebih dari 1 sehingga butuh foreach
                    foreach($sorts as $sort) {
                        if(isset($sort->isExpanded)) {
                            // TODO : terjadi ketika kolom sevagai group by di sort
                            if($sort->isExpanded) {
                                //
                            }
                        }

                        if($sort->desc) {
                            $item = $item->sortByDesc($sort->selector);
                        } else {
                            $item = $item->sortBy($sort->selector);
                        }
                    }
                }

                $resData[$i]['count'] =  $item->count();

                if($groups[0]->isExpanded == 'true') {
                    $resData[$i]['items'] = $item;
                } else {
                    $resData[$i]['items'] = null;
                }

                // TODO : cek hasilnya apakah sudah OK, dan cek logic untuk yang custom summary
                if($request->groupSummary) {
                    $resData[$i]['summary'] = [];
                    $gSummaries = json_decode($request->groupSummary);

                    foreach($gSummaries as $gSummary) {
                        $gCmd = $gSummary->summaryType;
                        array_push($resData[$i]['summary'], $inGroupData->$gCmd($gSummary->selector));
                    }
                }

                $i++;
            }
            

            // group header data
            $resData = collect($resData);
            if($request->skip) {
                $resData = $resData->slice($request->skip);
            }
            $res['data'] = $resData->take($request->take)->values();
        } else {
            if($request->sort) {
                $sorts = json_decode($request->sort);
                // TODO : cek apakah sort pada data yang tidak di grouping selalu array count = 1 atau bisa lebih dari 1 sehingga butuh foreach
                foreach($sorts as $sort) {
                    if(isset($sort->isExpanded)) {
                        // TODO : terjadi ketika kolom sevagai group by di sort
                        if($sort->isExpanded) {
                            //
                        }
                    }

                    if($sort->desc) {
                        $data = $data->orderBy($sort->selector, 'desc');
                    } else {
                        $data = $data->orderBy($sort->selector);
                    }
                }
            }

            if($request->skip) {
                $data = $data->skip($request->skip);
            }
            if($request->take) {
                $data = $data->take($request->take);
            }

            if($request->softdelete){
                $data = $data->whereNull("deleted_at");
            }
            $res['info']['sql'] = $data->toSql();

            $res['data'] = $data->get();
        }

        return $res;
    }

}