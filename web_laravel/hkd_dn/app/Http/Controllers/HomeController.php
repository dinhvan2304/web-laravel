<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\ClientsExport;

class HomeController extends Controller
{
    public function statistic(Request $request) {
      return view('public.statistic');
    }
    
    public function statisticSME(Request $request) {
      return view('public.statistic-sme');
    }

    public function statisticVnptThueBao(Request $request) {
      return view('public.statistic-vnptthuebao');
    }
    
    
    /**
     * Function directs users to default dashboard
     * @return view default user dashboard
     */
    public function statisticNewClients(Request $request)
    {
        $start_day = Carbon::now()->startOfYear();
        $end_day = Carbon::now();
        if($request->has('start_day')) {
          $start_day = Carbon::parse($request->start_day);
        }
        if($request->has('end_day')) {
          $end_day = Carbon::parse($request->end_day);
        }
        $enterpriseTotal = DB::select(DB::raw("select count(*) as total from clients where (created_date between '".$start_day->startOfDay()->toDateTimeString()."' AND '".$end_day->startOfDay()->toDateTimeString()."') and province is not null and province <> ''"));
        $enterpriseStats = DB::select(DB::raw("select * from (select count(*) as total, province from clients where (created_date between '".$start_day->startOfDay()->toDateTimeString()."' AND '".$end_day->startOfDay()->toDateTimeString()."') GROUP BY province) tmp where province is not null and province <> ''"));
        $enterpriseProvinceStats = DB::select(DB::raw("select * from (select count(*) as total, province_code from clients where (created_date between '".$start_day->startOfDay()->toDateTimeString()."' AND '".$end_day->startOfDay()->toDateTimeString()."') GROUP BY province_code) tmp where province_code is not null and province_code <> '' Order by total desc"));
        $totalOther = collect(collect($enterpriseProvinceStats)->slice(5)->all())->sum('total');
        $enterpriseProvinceStats = collect($enterpriseProvinceStats)->slice(0, 5)->all();
        array_push($enterpriseProvinceStats, (object)['total' => $totalOther, 'province_code' => 'Khác']);

        $enterpriseFieldStats = DB::select(DB::raw("select * from (select count(*) as total, main_business_code from clients where (created_date between '".$start_day->startOfDay()->toDateTimeString()."' AND '".$end_day->startOfDay()->toDateTimeString()."') GROUP BY main_business_code) tmp where main_business_code is not null and main_business_code <> '' Order by total desc"));
        $totalOtherField = collect(collect($enterpriseFieldStats)->slice(5)->all())->sum('total');
        $enterpriseFieldStats = collect($enterpriseFieldStats)->slice(0, 5)->all();
        array_push($enterpriseFieldStats, (object)['total' => $totalOtherField, 'main_business_code' => 'Khác']);

        

        $enterpriseTelcoStats = DB::select(DB::raw("select * from (select count(*) as total, telco from clients where (created_date between '".$start_day->startOfDay()->toDateTimeString()."' AND '".$end_day->startOfDay()->toDateTimeString()."') GROUP BY telco) tmp where telco is not null and telco <> '' Order by total desc"));
        $totalOtherTelco = collect(collect($enterpriseTelcoStats)->slice(3)->all())->sum('total');
        $enterpriseTelcoStats = collect($enterpriseTelcoStats)->slice(0, 3)->all();
        array_push($enterpriseTelcoStats, (object)['total' => $totalOtherTelco, 'telco' => 'Khác']);

        $enterpriseTypeStats = DB::select(DB::raw("select * from (select count(*) as total, enterprise_type from clients where (created_date between '".$start_day->startOfDay()->toDateTimeString()."' AND '".$end_day->startOfDay()->toDateTimeString()."') GROUP BY enterprise_type) tmp where enterprise_type is not null and enterprise_type <> '' Order by total desc"));
        $totalOtherType = collect(collect($enterpriseTypeStats)->slice(3)->all())->sum('total');
        $enterpriseTypeStats = collect($enterpriseTypeStats)->slice(0, 3)->all();
        //array_push($enterpriseTypeStats, (object)['total' => $totalOtherType, 'enterprise_type' => 'Khác']);

        // $enterpriseStats = DB::select(DB::raw("select * from (select count(*) as total, province from clients GROUP BY province) tmp where province is not null and province <> ''"));
        // dump(collect($enterpriseStats)->pluck('province'));
        // dd($enterpriseStats);
        return view('public.statistic-newclients')
          ->with('enterpriseTotal', $enterpriseTotal[0]->total)
          ->with('enterpriseStats', $enterpriseStats)
          ->with('enterpriseProvinceStats', $enterpriseProvinceStats)
          ->with('enterpriseFieldStats', $enterpriseFieldStats)
          ->with('enterpriseTelcoStats', $enterpriseTelcoStats)
          ->with('enterpriseTypeStats', $enterpriseTypeStats)
          ->with('start_day', $start_day)
          ->with('end_day', $end_day)
        ;
    }

    public function userHKD(Request $request) {
      $condition = "";
      if(Auth::user() && Auth::user()->hasRole('tracuuthuebaovnpt') && isset(Auth::user()->province)){
        $tinhthanh = Auth::user()->province;
        $condition = " join view_tinh_thanhs t on t.name = v.tinh and t.code = '$tinhthanh'";
      }
      $clients = DB::table(DB::raw("(
        select v.* from view_gdt v $condition
      ) tmp2"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }

    public function userVnptThueBao(Request $request) {
      $condition = "";
      if(Auth::user() && Auth::user()->hasRole('tracuuthuebaovnpt') && isset(Auth::user()->province)){
        $tinhthanh = Auth::user()->province;
        $condition = " join view_tinh_thanhs t on t.name = v.city and t.code = '$tinhthanh'";
      }
      $clients = DB::table(DB::raw("
        (
          select v.* from vnpt_thuebao v $condition
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function userHKDHistory(Request $request) {

      $histories = DB::table(DB::raw("
        (
          select * from view_gdt_history where MST = '$request->mst'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($histories);
  
      return $dx->invoke($request);
    }


    public function detailHKD(Request $request)
    {
      $mst = $request->mst;
      $detail = DB::table('view_gdt')->where('mst',$mst)->first();
      return view('public.detail-hkd')->with('detail', $detail);
    }

    public function detailHKDStatistic(Request $request) {
      
      $servicesStats = DB::select(DB::raw("
        select count(*) as number_services, TEN_DVVT, MST, DOANHTHU from view_gdt_history 
        where MST = '$request->mst'
        GROUP BY TEN_DVVT
      "));

      $totalServices = collect($servicesStats)->sum('number_services');
      $totalServicesDoanhThu = collect($servicesStats)->sum('DOANHTHU');

      return [
        'totalServices' => $totalServices,
        'totalServicesDoanhThu' => $totalServicesDoanhThu,
        'servicesStats' => $servicesStats,
      ];
    }
    public function userHKDHistoryTaxAll(Request $request) {
      $clients = DB::table(DB::raw("
      (
        select * from gdt_tax_all gtc where gtc.mst = '$request->mst'
      )tmp"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }

    public function userHKDHistoryTaxChange(Request $request) {
      $clients = DB::table(DB::raw("
      (
        select * from gdt_tax_changed gtc where gtc.mst = '$request->mst'
      )tmp"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function userHKDHistoryTaxOff(Request $request) {
      $clients = DB::table(DB::raw("
        (
          select * from gdt_tax_off gtc where gtc.mst = '$request->mst'
        )tmp
      "));
      $dx = new \App\Services\DatagridService($clients);
      return $dx->invoke($request);
    }
    
    public function userHKDHistoryTaxGtgt(Request $request) {
      $clients = DB::table(DB::raw("
        (
          select * from gdt_tax_without_gtgt gtc where gtc.mst = '$request->mst'
        )tmp
      "));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }

    public function userSmes(Request $request) {
      $clients = DB::table(DB::raw("clients"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }

    public function detailSmes(Request $request)
    {
      $id = $request->id;
      $detail = DB::table('clients')->where('id',$id)->first();
      return view('public.detail-smes')->with('detail', $detail);
    }

    public function statisticVnptThueBaoGrid(Request $request) {
      $statistic = DB::select(DB::raw("
        select city, isp, service, count(*) as total 
        from vnpt_thuebao c
        group by c.city,c.isp, c.service
      "));
      return [
        'statistic' => $statistic,
      ];
    }

    public function statisticVnptThueBaoList(Request $request) {
      $condition = "";
      if(isset($request->rowOpt2)){
        $condition .= " and c.isp = '$request->rowOpt2'";
      }
      $packages = DB::table(DB::raw("
        (
          select * 
          from vnpt_thuebao c
          where c.city = '$request->city' and c.service = '$request->colOpt' $condition
        ) tttt
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }

    public function statisticVnptThueBaoVnEduGrid(Request $request) {
      $statistic = DB::select(DB::raw("
        select city, isp, type, count(*) as total 
        from vnpt_thuebao c
        where c.service = 'vnedu'
        group by c.city,c.isp, c.type
      "));
      return [
        'statistic' => $statistic,
      ];
    }

    public function statisticVnptThueBaoVnEduList(Request $request) {
      $condition = " ";
      if(isset($request->colOpt)){
        $condition .= " and c.type = '$request->colOpt'";
      }
      if(isset($request->colOpt2)){
        $condition .= " and c.isp = '$request->colOpt2'";
      }
      $packages = DB::table(DB::raw("
        (
          select * 
          from vnpt_thuebao c
          where c.service = 'vnedu'
          and c.city = '$request->city' $condition
        ) tttt
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }

    public function statisticVnptThueBaoIgateGrid(Request $request) {
      $statistic = DB::select(DB::raw("
        select city, isp, type, count(*) as total 
        from vnpt_thuebao c
        where c.service = 'igate'
        group by c.city,c.isp, c.type
      "));
      return [
        'statistic' => $statistic,
      ];
    }

    public function statisticVnptThueBaoIgateList(Request $request) {
      $condition = "";
      if(isset($request->colOpt)){
        $condition .= " and c.type = '$request->colOpt'";
      }
      if(isset($request->colOpt2)){
        $condition .= " and c.isp = '$request->colOpt2'";
      }
      $packages = DB::table(DB::raw("
        (
          select * 
          from vnpt_thuebao c
          where c.service = 'igate'
          and c.city = '$request->city' $condition
        ) tttt
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }

    public function statisticSMEs(Request $request) {
      $statistic = DB::select(DB::raw("
          select province, city, district, count(*) as total 
          from clients c
          group by c.district
      "));
      return [
        'statistic' => $statistic,
      ];
    }

    public function statisticSMEsList(Request $request) {
      $condition = "";
      if(isset($request->huyen)){
        $condition .= " and c.city = '$request->huyen'";
      }
      if(isset($request->xa)){
        $condition .= " and c.district = '$request->xa'";
      }
      $packages = DB::table(DB::raw("
        (
          select * 
          from clients c
          where c.province = '$request->tinh' $condition
        ) tttt
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }
    public function statisticGdt(Request $request) {
      $statistic = DB::select(DB::raw("
          select tinh, huyen, xa, count(*) as total 
          from view_gdt vg
          where client_type = 'Hộ kinh doanh cá thể'
          group by vg.xa
      "));
      return [
        'statistic' => $statistic,
      ];
    }

    public function statisticGdtList(Request $request) {
      $condition = "";
      if(isset($request->huyen)){
        $condition .= " and vg.huyen = '$request->huyen'";
      }
      if(isset($request->xa)){
        $condition .= " and vg.xa = '$request->xa'";
      }
      $packages = DB::table(DB::raw("
        (
          select * 
          from view_gdt vg
          where client_type = 'Hộ kinh doanh cá thể' and vg.tinh = '$request->tinh' $condition
        ) tttt
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }
    public function smes()
    {
      return view('public.smes');
    }
    public function hkd()
    {
      return view('public.hkd');
    }
    public function vnptthuebao()
    {
      return view('public.vnptthuebao');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return redirect('/dashboard/ca-service');
    }


    public function dashboardCaService(Request $request){
        return view('public.ca-service');
    }

    public function apiDashboardCaServiceExport(Request $request) {
      $conditions = " where 1=1";
	    $exportType = $request->exportType;
      if(isset($request->tinh) && $request->tinh != "null"){
        $conditions .= " and tinh = '$request->tinh'";
      }
      if(isset($request->package) && $request->package != "null"){
        $conditions .= " and package = '$request->package'";
      }
      if(isset($request->year) && $request->year != "null"){
        $conditions .= " and year = $request->year";
      }
      if(isset($request->caTypes) && $request->caTypes != "null"){
        $conditions .= " and isCA = '$request->caTypes'";
      }
      if(isset($request->customerTypes) && $request->customerTypes != "null"){
        $conditions .= " and customerType = '$request->customerTypes'";
      }
      $conditionsThisMonth = " and month = $request->month";
      $conditionsLuyKe = " and month <= $request->month";

      $myQuery = "";
      if($exportType == "1"){
        $myQuery = "
        select * from cangiahan_detail $conditions $conditionsThisMonth
        ";
      }else if($exportType == "2"){
        $myQuery = "
        select * from dagiahan_detail $conditions $conditionsThisMonth
        ";
      }else if($exportType == "3"){
        $myQuery = "
        select * from cangiahan_detail $conditions $conditionsThisMonth and serial_number not in (select previousSerialNumber from dagiahan_detail $conditions $conditionsThisMonth)
        ";
      }else if($exportType == "4"){
        $myQuery = "
        select * from capbu_detail $conditions $conditionsLuyKe
        ";
      }
      $data = DB::table(DB::raw("
        (
          $myQuery
        ) tmp2324234
      "));
      // $data = DB::select(DB::raw($myQuery));
      $dx = new \App\Services\DatagridService($data);
      return $dx->invoke($request);
    }


    public function export(Request $request)
    {
      $start_day = Carbon::now()->startOfMonth();
      $end_day = Carbon::now();
      if($request->has('start_day')) {
          $start_day = Carbon::parse($request->start_day);
      }
      if($request->has('end_day')) {
          $end_day = Carbon::parse($request->end_day);
      }
      return Excel::download(new ClientsExport($start_day, $end_day), 'clients.xlsx');
    }

    public function apiDashboardCaService(Request $request) {
      
      $tinhthanh = $request->tinh;
      if(Auth::user() && Auth::user()->hasRole('tracuuthuebaovnpt') && isset(Auth::user()->province)){
        $tinhthanh = Auth::user()->province;
      }
      $normalCondition = " where 1=1";
      $conditionKeHoachs = " where 1=1";

      $conditionPtm = "and type = 'moi'";
      $conditionGh = "and type = 'giahan'";

      $premonth = ($request->month - 1) > 0?$request->month - 1:null;
      $lastyear = ($request->year - 1) > 0?$request->year - 1:null;

      $conditionsYear = " and year = $request->year";
      $conditionsLastYear = " and year = $lastyear";
      
      $conditionsThisMonth = " and month = $request->month";
      $conditionsPreMonth = " and month = $premonth";
      $conditionsPreYear = $conditionsYear;

	  if($request->month == "1"){
		$year = $request->year - 1;
		$conditionsPreYear = " and year = $year";
		$conditionsPreMonth = " and month = 12";
	  }

      $conditionsLuyKe = " and month <= $request->month";
      
      if(isset($tinhthanh) && $tinhthanh != "null"){
        $normalCondition .= " and tinh = '$tinhthanh'";
        $conditionKeHoachs .= " and tinh = '$tinhthanh'";
      }
      if(isset($request->package) && $request->package != "null"){
        $normalCondition .= " and package = '$request->package'";
      }
      if(isset($request->caTypes) && $request->caTypes != "null"){
        $normalCondition .= " and isCA = '$request->caTypes'";
        $conditionKeHoachs .= " and isCA = '$request->caTypes'";
      }
      if(isset($request->customerTypes) && $request->customerTypes != "null"){
        $normalCondition .= " and customerType = '$request->customerTypes'";
      }

      $myQuery = "
      select 
        sltmp.*,
        ifnull(cgh.total_cangiahan,0) as total_cangiahan,
        (ifnull(cgh.total_cangiahan,0) - ifnull(dgh.total_dagiahan,0)) as total_chuagiahan,
        ifnull(lkcgh.total_luykecangiahan,0) as total_luykecangiahan,
        ifnull(lkdgh.total_luykedagiahan,0) as total_luykedagiahan,
        ifnull(cb.total_capbu,0) as total_capbu,
        ifnull(lkcb.total_luykecapbu,0) as total_luykecapbu,
        ifnull(cm.total_capmoi,0) as total_capmoi,
        ifnull(lkcm.total_luykecapmoi,0) as total_luykecapmoi,
        ifnull(lkth.total_luykethuhoi,0) as total_luykethuhoi,
        ifnull(dgh.total_dagiahan,0) as total_dagiahan,
        ifnull(pcm.total_premonthcapmoi,0) as total_premonthcapmoi,
        ifnull(pdgh.total_premonthdagiahan,0) as total_premonthdagiahan,
        ifnull(lkcmly.total_luykecapmoilastyear,0) as total_luykecapmoilastyear,
        ifnull(lkdghly.total_luykedagiahanlastyear,0) as total_luykedagiahanlastyear,
        (ifnull(dgh.total_dagiahan,0) + ifnull(cm.total_capmoi,0)) as total_sanluong,
        (ifnull(pdgh.total_premonthdagiahan,0) + ifnull(pcm.total_premonthcapmoi,0)) as total_premonthsanluong,
        (ifnull(lkdgh.total_luykedagiahan,0) + ifnull(lkcm.total_luykecapmoi,0)) as total_luykesanluong,
        (ifnull(lkcmly.total_luykecapmoilastyear,0) + ifnull(lkdghly.total_luykedagiahanlastyear,0)) as total_luykesanluonglastyear,
        ifnull(lkdhd.total_luykedanghoatdong,0) as total_luykedanghoatdong,
        ifnull(th.total_thuhoi,0) as total_thuhoi
      from (
        select tinh
        , sum(thang_1) as thang_1
        , sum(thang_2) as thang_2
        , sum(thang_3) as thang_3
        , sum(thang_4) as thang_4
        , sum(thang_5) as thang_5
        , sum(thang_6) as thang_6
        , sum(thang_7) as thang_7
        , sum(thang_8) as thang_8
        , sum(thang_9) as thang_9
        , sum(thang_10) as thang_10
        , sum(thang_11) as thang_11
        , sum(thang_12) as thang_12
        , sum(total_year) as total_year
        from kehoach_sl sl $conditionKeHoachs $conditionsYear group by tinh
      ) sltmp
      LEFT JOIN (
        select tinh, SUM(total) as total_cangiahan from cangiahan_total $normalCondition $conditionsYear $conditionsThisMonth
      ) cgh on cgh.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_luykecangiahan from cangiahan_total  $normalCondition $conditionsYear $conditionsLuyKe
      ) lkcgh on lkcgh.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_capbu from capbu_total  $normalCondition $conditionsYear $conditionsThisMonth
      ) cb on cb.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_luykecapbu from capbu_total $normalCondition $conditionsYear $conditionsLuyKe
      ) lkcb on lkcb.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_capmoi from capmoi_total  $normalCondition $conditionsYear $conditionsThisMonth
      ) cm on cm.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_luykecapmoi from capmoi_total  $normalCondition $conditionsYear $conditionsLuyKe
      ) lkcm on lkcm.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_dagiahan from dagiahan_total $normalCondition $conditionsYear $conditionsThisMonth
      ) dgh on dgh.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_luykedagiahan from dagiahan_total $normalCondition $conditionsYear $conditionsLuyKe
      ) lkdgh on lkdgh.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_danghoatdong from danghoatdong_total $normalCondition $conditionsYear $conditionsThisMonth
      ) dhd on dhd.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_luykedanghoatdong from danghoatdong_total $normalCondition $conditionsYear $conditionsThisMonth
      ) lkdhd on lkdhd.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_thuhoi from thuhoi_total $normalCondition $conditionsYear $conditionsThisMonth
      ) th on th.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_luykethuhoi from thuhoi_total $normalCondition $conditionsYear $conditionsLuyKe
      ) lkth on lkth.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_premonthcapmoi from capmoi_total $normalCondition $conditionsPreYear $conditionsPreMonth
      ) pcm on pcm.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_premonthdagiahan from dagiahan_total $normalCondition $conditionsPreYear $conditionsPreMonth
      ) pdgh on pdgh.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_luykecapmoilastyear from capmoi_total $normalCondition $conditionsLastYear $conditionsLuyKe
      ) lkcmly on lkcmly.tinh = sltmp.tinh or sltmp.tinh is null
      LEFT JOIN (
        select tinh, SUM(total) as total_luykedagiahanlastyear from dagiahan_total $normalCondition $conditionsLastYear $conditionsLuyKe
      ) lkdghly on lkdghly.tinh = sltmp.tinh or sltmp.tinh is null
      ";
      // dd($myQuery);

      $statistic = DB::select(DB::raw($myQuery));

      $myQuery1 = "
        select dt.*, 
        dgh.total_dagiahan, 
        cgh.total_cangiahan, 
        (cgh.total_cangiahan - dgh.total_dagiahan) as total_chuagiahan , 
        cm.total_capmoi, lkcgh.total_luykecangiahan,
        dgh.total_dagiahan + cm.total_capmoi as total_sanluong, 
        cm.total_capmoi/dt.thang_$request->month as percent_taomoi,
        cgh.total_cangiahan/dt.thang_$request->month as percent_cangiahan,
        dgh.total_dagiahan/dt.thang_$request->month as percent_giahan,
        (cgh.total_cangiahan - dgh.total_dagiahan)/dt.thang_$request->month as percent_chuagiahan

        from (
          select tinh
          , sum(thang_1) as thang_1
          , sum(thang_2) as thang_2
          , sum(thang_3) as thang_3
          , sum(thang_4) as thang_4
          , sum(thang_5) as thang_5
          , sum(thang_6) as thang_6
          , sum(thang_7) as thang_7
          , sum(thang_8) as thang_8
          , sum(thang_9) as thang_9
          , sum(thang_10) as thang_10
          , sum(thang_11) as thang_11
          , sum(thang_12) as thang_12
          , sum(total_year) as total_year
          from kehoach_sl sl $conditionKeHoachs $conditionsYear group by tinh
        ) dt
        LEFT JOIN (
          select tinh, total as total_dagiahan from dagiahan_total $normalCondition $conditionsYear $conditionsThisMonth GROUP BY tinh
        ) dgh on dgh.tinh = dt.tinh
        LEFT JOIN (
          select tinh, total as total_cangiahan from cangiahan_total $normalCondition $conditionsYear $conditionsThisMonth GROUP BY tinh
        ) cgh on cgh.tinh = dt.tinh
        LEFT JOIN (
          select tinh, total as total_capmoi from capmoi_total $normalCondition $conditionsYear  $conditionsThisMonth GROUP BY tinh
        ) cm on cm.tinh = dt.tinh
        LEFT JOIN (
          select tinh, SUM(total) as total_luykecangiahan from cangiahan_total $normalCondition $conditionsYear  $conditionsLuyKe GROUP BY tinh
        ) lkcgh on lkcgh.tinh = dt.tinh
        where dt.tinh is not null
      ";
      $statisticTinh = DB::select(DB::raw($myQuery1));


      $myQueryPtm = "
      select '' as tinh
          , sum(thang_1) as thang_1
          , sum(thang_2) as thang_2
          , sum(thang_3) as thang_3
          , sum(thang_4) as thang_4
          , sum(thang_5) as thang_5
          , sum(thang_6) as thang_6
          , sum(thang_7) as thang_7
          , sum(thang_8) as thang_8
          , sum(thang_9) as thang_9
          , sum(thang_10) as thang_10
          , sum(thang_11) as thang_11
          , sum(thang_12) as thang_12
          , sum(total_year) as total_year
          from kehoach_sl_detail sl_kehoach  $conditionKeHoachs $conditionsYear $conditionPtm
          union
      select tinh
          , sum(thang_1) as thang_1
          , sum(thang_2) as thang_2
          , sum(thang_3) as thang_3
          , sum(thang_4) as thang_4
          , sum(thang_5) as thang_5
          , sum(thang_6) as thang_6
          , sum(thang_7) as thang_7
          , sum(thang_8) as thang_8
          , sum(thang_9) as thang_9
          , sum(thang_10) as thang_10
          , sum(thang_11) as thang_11
          , sum(thang_12) as thang_12
          , sum(total_year) as total_year
          from kehoach_sl_detail sl_kehoach $conditionKeHoachs $conditionsYear $conditionPtm group by tinh
      ";
      $statisticPtm = DB::select(DB::raw($myQueryPtm));

      $myQueryGh = "
      select '' as tinh
          , sum(thang_1) as thang_1
          , sum(thang_2) as thang_2
          , sum(thang_3) as thang_3
          , sum(thang_4) as thang_4
          , sum(thang_5) as thang_5
          , sum(thang_6) as thang_6
          , sum(thang_7) as thang_7
          , sum(thang_8) as thang_8
          , sum(thang_9) as thang_9
          , sum(thang_10) as thang_10
          , sum(thang_11) as thang_11
          , sum(thang_12) as thang_12
          , sum(total_year) as total_year
          from kehoach_sl_detail sl_kehoach  $conditionKeHoachs $conditionsYear $conditionGh
          union
      select tinh
          , sum(thang_1) as thang_1
          , sum(thang_2) as thang_2
          , sum(thang_3) as thang_3
          , sum(thang_4) as thang_4
          , sum(thang_5) as thang_5
          , sum(thang_6) as thang_6
          , sum(thang_7) as thang_7
          , sum(thang_8) as thang_8
          , sum(thang_9) as thang_9
          , sum(thang_10) as thang_10
          , sum(thang_11) as thang_11
          , sum(thang_12) as thang_12
          , sum(total_year) as total_year
          from kehoach_sl_detail sl_kehoach $conditionKeHoachs $conditionsYear $conditionGh group by tinh
      ";
      $statisticGh = DB::select(DB::raw($myQueryGh));

      return [
        "myQuery" => $myQuery,
        "myQuery1" => $myQuery1,
        "myQueryPtm" => $myQueryPtm,
        "myQueryGh" => $myQueryGh,
        "statistic" => $statistic,
        "statisticTinh" => $statisticTinh,
        "statisticPtm" => $statisticPtm,
        "statisticGh" => $statisticGh
      ];
    }
    
    public function dashboardCaRevenue(Request $request)
    {
      return view('public.ca-revenue');
    }


    public function apiDashboardCaRevenue(Request $request) {

      $conditions = " where 1=1";
      $conditions2 = " where 1=1";
      if(isset($request->tinh) && $request->tinh != "null"){
        $conditions .= " and tinh = '$request->tinh'";
        $conditions2 .= " and tinh = '$request->tinh'";
      }
      if(isset($request->package) && $request->package != "null"){
        $conditions .= " and package = '$request->package'";
        $conditions2 .= " and package = '$request->package'";
      }
      if(isset($request->year) && $request->year != "null"){
        $conditions .= " and year = '$request->year'";
        $conditions2 .= " and year = '$request->year'";
      }
      if(isset($request->month) && $request->month != "null"){
        $conditions .= " and month = '$request->month'";
        $conditions2 .= " and month <= '$request->month'";
      }
      $myQuery = "
        select sltmp.*, 
          tmp1.total_giahan, tmp2.total_cangiahan, tmp3.total_khonggiahan , tmp4.total_taomoi , tmp1.total_giahan + tmp4.total_taomoi as total_sanluong, 
          tmp5.total_luykegiahan, tmp6.total_luykecangiahan, tmp7.total_luykekhonggiahan , tmp8.total_luyketaomoi ,
          tmp4.total_taomoi/sltmp.thang_$request->month as percent_taomoi,
          tmp2.total_cangiahan/sltmp.thang_$request->month as percent_cangiahan,
          tmp1.total_giahan/sltmp.thang_$request->month as percent_giahan,
          tmp3.total_khonggiahan/sltmp.thang_$request->month as percent_khonggiahan,
          tmp8.total_luyketaomoi/sltmp.total_year as percent_luyketaomoi,
          tmp6.total_luykecangiahan/sltmp.total_year as percent_luykecangiahan,
          tmp5.total_luykegiahan/sltmp.total_year as percent_luykegiahan,
          tmp7.total_luykekhonggiahan/sltmp.total_year as percent_luykekhonggiahan
        from (
          select * from kehoach_dt dt where dt.tinh is null
        ) sltmp
        LEFT JOIN (
          select ttkd, count(*) as total_giahan from dagiahan_detail $conditions
        ) tmp1 on 1 = 1
        LEFT JOIN (
          select ttkd, count(*) as total_cangiahan from cangiahan_detail $conditions
        ) tmp2 on tmp2.ttkd = tmp1.ttkd
        LEFT JOIN (
          select ttkd, count(*) as total_khonggiahan from khonggiahan_detail $conditions
        ) tmp3 on tmp3.ttkd = tmp1.ttkd
        LEFT JOIN (
          select ttkd, count(*) as total_taomoi from taomoi_detail $conditions
        ) tmp4 on tmp4.ttkd = tmp1.ttkd
        LEFT JOIN (
          select ttkd, count(*) as total_luykegiahan from dagiahan_detail $conditions2
        ) tmp5 on tmp5.ttkd = tmp1.ttkd
        LEFT JOIN (
          select ttkd, count(*) as total_luykecangiahan from cangiahan_detail $conditions2
        ) tmp6 on tmp6.ttkd = tmp1.ttkd
        LEFT JOIN (
          select ttkd, count(*) as total_luykekhonggiahan from khonggiahan_detail $conditions2
        ) tmp7 on tmp7.ttkd = tmp1.ttkd
        LEFT JOIN (
          select ttkd, count(*) as total_luyketaomoi from taomoi_detail $conditions2
        ) tmp8 on tmp8.ttkd = tmp1.ttkd

      ";
      $statistic = DB::select(DB::raw($myQuery));
      $conditions = " where 1=1";
      if(isset($request->package) && $request->package != "null"){
        $conditions .= " and package = '$request->package'";
      }
      if(isset($request->year) && $request->year != "null"){
        $conditions .= " and year = '$request->year'";
      }
      if(isset($request->month) && $request->month != "null"){
        $conditions .= " and month = '$request->month'";
      }
      $myQuery1 = "
        select dt.*, tmp1.total_giahan, tmp2.total_cangiahan, tmp3.total_khonggiahan , tmp4.total_taomoi, 
          tmp1.total_giahan + tmp4.total_taomoi as total_sanluong, 
          tmp4.total_taomoi/dt.thang_$request->month as percent_taomoi,
          tmp2.total_cangiahan/dt.thang_$request->month as percent_cangiahan,
          tmp1.total_giahan/dt.thang_$request->month as percent_giahan,
          tmp3.total_khonggiahan/dt.thang_$request->month as percent_khonggiahan

        from kehoach_dt dt
        LEFT JOIN (
          select tinh, count(*) as total_giahan from dagiahan_detail $conditions GROUP BY tinh
        ) tmp1 on tmp1.tinh = dt.tinh
        LEFT JOIN (
          select tinh, count(*) as total_cangiahan from cangiahan_detail $conditions GROUP BY tinh
        ) tmp2 on tmp2.tinh = dt.tinh
        LEFT JOIN (
          select tinh, count(*) as total_khonggiahan from khonggiahan_detail $conditions GROUP BY tinh
        ) tmp3 on tmp3.tinh = dt.tinh
        LEFT JOIN (
          select tinh, count(*) as total_taomoi from taomoi_detail $conditions GROUP BY tinh
        ) tmp4 on tmp4.tinh = dt.tinh
        where dt.tinh is not null

      ";
      $statisticTinh = DB::select(DB::raw($myQuery1));
      return [
        "myQuery" => $myQuery,
        "myQuery1" => $myQuery1,
        "statistic" => $statistic,
        "statisticTinh" => $statisticTinh
      ];
    }
    public function apiDashboardCaTTKDs(Request $request) {
	  $condition = "";
	  if(Auth::user() && Auth::user()->hasRole('tracuuthuebaovnpt') && isset(Auth::user()->province)){
		  $condition = " and value = '".Auth::user()->province."'";
	  }
      $clients = DB::table(DB::raw("(
        select name, value from danhmuc where type = 1 $condition
      ) tmp2"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function apiDashboardCaPackages(Request $request) {
      $clients = DB::table(DB::raw("(
        select name, value from danhmuc where type = 4
      ) tmp2"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function apiDashboardCaTypes(Request $request) {
      $clients = DB::table(DB::raw("(
        select name, value from danhmuc where type = 2
      ) tmp2"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function apiDashboardCaCustomerTypes(Request $request) {
      $clients = DB::table(DB::raw("(
        select name, value from danhmuc where type = 5
      ) tmp2"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function apiDashboardCaStations(Request $request) {
      $clients = DB::table(DB::raw("(
        select DISTINCT(package) from dagiahan_detail
      ) tmp2"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
}
