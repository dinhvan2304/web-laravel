<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cache;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\ClientsExport;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        if(setting('email_verification')){
          $this->middleware(['verified']);
        }
        $this->middleware(['auth','2fa','web']);
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {

      return view('public.home');
    }

    public function packagesRejoin()
    {
      return view('public.packages-rejoin');
    }
    public function statisticCity(Request $request) {
      return view('public.statistic-city');
    }
    public function statisticcompetitor(Request $request) {
      return view('public.statistic-competitor');
    }
    public function statisticProvinces(Request $request) {
      return view('public.statistic-provinces');
    }
    public function statisticClients(Request $request) {
      return view('public.statistic-clients');
    }
    public function statisticPackages(Request $request) {
      return view('public.statistic-packages');
    }
    public function detailPackages(Request $request)
    {
      $so_tbmt = $request->so_tbmt;
      $detail = DB::table('thong_tin_goi_thau')->where('so_tbmt',$so_tbmt)->first();
      return view('public.detail-packages')->with('detail', $detail);
    }
	
    public function detailCompetitors(Request $request)
    {
      $mst = $request->mst;
      $detail = DB::table('competitors')->where('so_dkkd',$mst)->first();
      return view('public.detail-competitors')->with('detail', $detail);
    }
    public function detailClients(Request $request)
    {
      $mst = $request->mst;
      $detail = DB::table('clients')->where('so_dkkd',$mst)->first();
      return view('public.detail-clients')->with('detail', $detail);
    }
    public function detailPlans(Request $request)
    {
      $so_khlcnt = $request->so_khlcnt;
      $detail = DB::table('bidder_plan_table')->where('so_khlcnt',$so_khlcnt)->first();
      return view('public.detail-plans')->with('detail', $detail);
    }

    public function detailClientCompetitor(Request $request)
    {
      $client_mst = $request->client_mst;
      $competitor_mst = $request->competitor_mst;
      $detailClient = DB::table('clients')->where('so_dkkd',$client_mst)->first();
      $detailCompetitor = DB::table('competitors')->where('so_dkkd',$competitor_mst)->first();
      return view('public.detail-client-competitor')->with('detailClient', $detailClient)->with('detailCompetitor', $detailCompetitor);
    }
    public function detailCompetitorCompetitor(Request $request)
    {
      $competitor1_mst = $request->competitor1_mst;
      $competitor2_mst = $request->competitor2_mst;
      $detailCompetitor1 = DB::table('competitors')->where('so_dkkd',$competitor1_mst)->first();
      $detailCompetitor2 = DB::table('competitors')->where('so_dkkd',$competitor2_mst)->first();
      return view('public.detail-competitor-competitor')->with('detailCompetitor1', $detailCompetitor1)->with('detailCompetitor2', $detailCompetitor2);
    }

    public function plans()
    {
      return view('public.plans');
    }
    public function packages()
    {
      return view('public.packages');
    }
	
    public function competitors()
    {
      return view('public.competitors');
    }
    public function clients()
    {
      return view('public.clients');
    }
    public function businesses()
    {
      return view('public.businesses');
    }

    public function procuringEntity()
    {
      return view('public.procuringEntity');
    }
    
    public function category_items()
    {
      return view('public.items');
    }

    public function bidder()
    {
      return view('public.bidder');
    }

    public function provinces()
    {
      return view('public.provinces');
    }

    public function dashboardStatistic(Request $request) {
      
      $start_day = Carbon::now()->startOfYear();
      $end_day = Carbon::now();
      $timeOut = 6000;
      if($request->has('start_day')) {
        $start_day = Carbon::parse($request->start_day);
      }
      if($request->has('end_day')) {
        $end_day = Carbon::parse($request->end_day);
      }
      $statistic = Cache::remember("statistic_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
          select 
            count(*) as number_packages, 
            sum(tt.gia_trung_thau) AS number_packages_value,
            tmp.number_vnpt,
            tmp.number_vnpt_value
          from thong_tin_goi_thau tt
          join (
            select 
              count(*) as number_vnpt, 
              sum(tt.gia_trung_thau) AS `number_vnpt_value`
            from thong_tin_goi_thau tt
            join competitors c on tt.competitor_id = c.so_dkkd
            where c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          ) tmp on 1=1
          where tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
        "));
      });
      
      $number_packages = collect($statistic)->sum('number_packages');
      $number_packages_value = collect($statistic)->sum('number_packages_value');
      $number_vnpt = collect($statistic)->sum('number_vnpt');
      $number_vnpt_value = collect($statistic)->sum('number_vnpt_value');
	  
      $statistic_province = Cache::remember("statistic_province_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
          select count(*) as number_packages, 
            sum(gia_trung_thau) AS `total_gia_trung_thau`,
            province_code 
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          group by c.province_code
        "));
      });
      $statistic_linhvuc = Cache::remember("statistic_linhvuc_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
          select 
            count(*) as total_packages,
            linh_vuc
          from thong_tin_goi_thau tt
          where tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          group by linh_vuc
          order by total_packages desc
        "));
      });
      $top5_clients = Cache::remember("top5_clients_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
            SELECT
              count( 0 ) AS `number_packages`,
              `c`.company_name,
              `c`.`id` AS `id`,
              `c`.`so_dkkd` AS `so_dkkd`,
              sum( `tt`.`gia_trung_thau` ) AS `total_gia_trung_thau`
            FROM `thong_tin_goi_thau` `tt`
            JOIN (
                  SELECT
                    count( 0 ) AS `total_pacs`,
                    `tt2`.`company_id` AS `company_id` 
                  FROM
                    `thong_tin_goi_thau` `tt2` 
                  WHERE `tt2`.company_id IS NOT NULL and `tt2`.company_id <> '' and  tt2.score_service > 0.4
                  GROUP BY `tt2`.`company_id` 
                  ORDER BY `total_pacs` DESC 
                  LIMIT 5
            ) `t2` ON `t2`.`company_id` = `tt`.`company_id`
            JOIN `clients` `c` ON	`c`.`company_id` = `tt`.`company_id` 
            where tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            GROUP BY `c`.`id` 
            ORDER BY `c`.`id` 
          "));
        });
      $top5_competitors = Cache::remember("top5_competitors_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
          SELECT
            count( 0 ) AS `number_packages`,
            `c`.`name_vi` AS `name_vi`,
            `c`.`id` AS `id`,
            `c`.`so_dkkd` AS `so_dkkd`,
            sum( `tt`.`gia_trung_thau` ) AS `total_gia_trung_thau`
          FROM `thong_tin_goi_thau` `tt`
          JOIN (
                SELECT
                  count( 0 ) AS `total_pacs`,
                  `tt2`.`competitor_id` AS `competitor_id` 
                FROM
                  `thong_tin_goi_thau` `tt2` 
                WHERE `tt2`.`competitor_id` IS NOT NULL and `tt2`.`competitor_id` <> '' and  tt2.score_service > 0.4
                GROUP BY `tt2`.`competitor_id` 
                ORDER BY `total_pacs` DESC 
                LIMIT 5
          ) `t2` ON `t2`.`competitor_id` = `tt`.`competitor_id`
          JOIN `competitors` `c` ON	`c`.`so_dkkd` = `tt`.`competitor_id` 
          where tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          GROUP BY `c`.`id` 
          ORDER BY `c`.`id`  
        "));
      });

      $vnpt_statistic_winjoins = Cache::remember("vnpt_statistic_winjoins_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
          select 
            count(*) as total_packages,
            'Thắng' as name
          from thong_tin_goi_thau tt
          join competitors c on tt.competitor_id = c.so_dkkd
          where c.is_vnpt = 1 and tt.score_service > 0.4

          union

          select 
            count(*) as total_packages,
            'Tham dự' as name
          from `competitors` c 
          inner join `bidder_tender` on `bidder_tender`.`so_dkkd` = c.`so_dkkd` 
          where c.is_vnpt = 1
        "));
      });
      $vnpt_statistic_packages = Cache::remember("vnpt_statistic_packages_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
            select count(*) as number_packages, 
              'Gov địa phương' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where c.is_govdp = 1 and c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            union 
            select count(*) as number_packages, 
              'Báo đài' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where c.is_baodai = 1 and c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            union 
            select count(*) as number_packages, 
              'Bộ ban ngành' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where c.is_bobannganh = 1 and c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            union 
            select count(*) as number_packages, 
              'Y tế' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where c.is_yte = 1 and c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            
            union 
            select count(*) as number_packages, 
              'Doanh nghiệp địa phương' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where c.is_dndp = 1 and c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            
            union 
            select count(*) as number_packages, 
              'Ngân hàng' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where c.is_nganhang = 1 and c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            
            union 
            select count(*) as number_packages, 
              'Tổng công ty' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where c.is_tct = 1 and c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            
            union 
            select count(*) as number_packages, 
              'Trường' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where c.is_truong = 1 and c.is_vnpt = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          "));
      });
      $vnpt_statistic_units = Cache::remember("vnpt_statistic_units_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
          select 
            count(*) as number_packages, 
            sum(gia_trung_thau) AS `total_gia_trung_thau`,
            c.name_vi
          from thong_tin_goi_thau tt
          join competitors c on tt.competitor_id = c.so_dkkd
          where c.is_vnpt = 1 and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          group by c.id
          order by number_packages desc
          limit 5
        "));
      });

      $statistic_block_packages = Cache::remember("statistic_block_packages_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
          select count(*) as number_packages, 
            'Gov địa phương' as name
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where c.is_govdp = 1
          and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')

          union 

          select count(*) as number_packages, 
            'Báo đài' as name
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where c.is_baodai = 1
          and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')

          union 

          select count(*) as number_packages, 
            'Bộ ban ngành' as name
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where c.is_bobannganh = 1
          and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')

          union 

          select count(*) as number_packages, 
            'Y tế' as name
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where c.is_yte = 1
          and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          
          union 

          select count(*) as number_packages, 
            'Doanh nghiệp địa phương' as name
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where c.is_dndp = 1
          and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          
          union 

          select count(*) as number_packages, 
            'Ngân hàng' as name
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where c.is_nganhang = 1
          and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          
          union 

          select count(*) as number_packages, 
            'Tổng công ty' as name
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where c.is_tct = 1
          and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          
          union 

          select count(*) as number_packages, 
            'Trường' as name
          from thong_tin_goi_thau tt
          join clients c on tt.company_id = c.company_id
          where c.is_truong = 1
          and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
        "));
      });
      
      $statistic_block_packages_value = Cache::remember("statistic_block_packages_value_".$start_day->format('Ymd')."_".$end_day->format('Ymd'),$timeOut, 
        function () use($start_day, $end_day) {
          return DB::select(DB::raw("
            select count(*) as number_packages, 
            sum(gia_trung_thau) AS `total_gia_trung_thau`,
              'Gov địa phương' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where is_govdp = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')

            union 

            select count(*) as number_packages, 
              sum(gia_trung_thau) AS `total_gia_trung_thau`,
              'Báo đài' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where is_baodai = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')

            union 

            select count(*) as number_packages, 
              sum(gia_trung_thau) AS `total_gia_trung_thau`,
              'Bộ ban ngành' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where is_bobannganh = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')

            union 

            select count(*) as number_packages, 
              sum(gia_trung_thau) AS `total_gia_trung_thau`,
              'Y tế' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where is_yte = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            
            union 

            select count(*) as number_packages, 
              sum(gia_trung_thau) AS `total_gia_trung_thau`,
              'Doanh nghiệp địa phương' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where is_dndp = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            
            union 

            select count(*) as number_packages, 
              sum(gia_trung_thau) AS `total_gia_trung_thau`,
              'Ngân hàng' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where is_nganhang = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            
            union 

            select count(*) as number_packages, 
              sum(gia_trung_thau) AS `total_gia_trung_thau`,
              'Tổng công ty' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where is_tct = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
            
            union 

            select count(*) as number_packages, 
              sum(gia_trung_thau) AS `total_gia_trung_thau`,
              'Trường' as name
            from thong_tin_goi_thau tt
            join clients c on tt.company_id = c.company_id
            where is_truong = 1
            and tt.score_service > 0.4 and (tt.nhan_e_hsdt_den_ngay between '".$start_day->format('Ymd')."' AND '".$end_day->format('Ymd')."')
          "));
        });
      return [
        'statistic' => $statistic,
        'statistic_province' => $statistic_province,
        'statistic_linhvuc' => $statistic_linhvuc,
        'vnpt_statistic_packages' => $vnpt_statistic_packages,
        'vnpt_statistic_units' => $vnpt_statistic_units,
        'vnpt_statistic_winjoins' => $vnpt_statistic_winjoins,
        'statistic_block_packages' => $statistic_block_packages,
        'statistic_block_packages_value' => $statistic_block_packages_value,
        'top5_clients' => $top5_clients,
        'top5_competitors' => $top5_competitors,
        'number_packages' => $number_packages,
        'number_vnpt' => $number_vnpt,
        'number_packages_value' => $number_packages_value,
        'number_vnpt_value' => $number_vnpt_value,
      ];
    }
    public function manageClients(Request $request){
      $clients = DB::table(DB::raw("
      (
        select clients.company_name, clients.city, clients.id, clients.address, clients.head_id from `clients`
      ) tmp2
    "));
      $dx = new \App\Services\DatagridService($clients);

      return $dx->invoke($request); 
    }

    public function getCompaniesClient(Request $request){
      $companies = DB::table(DB::raw("
        (
          select clients.id, clients.company_name from `clients`
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($companies);

      return $dx->invoke($request);  
	  }

    public function getCompaniesKey(Request $request){
      $id = $request->id;
      $company = DB::table(DB::raw("(select clients.id, clients.company_name from `clients` where clients.id=$id) tmp2"));
      $dx = new \App\Services\DatagridService($company);
      return $dx->invoke($request);
    }

    public function userPlans(Request $request) {
      $clients = DB::table(DB::raw("view_plans"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }

    public function userPlansPackages(Request $request) {
      $clients = DB::table(DB::raw("view_plans_packages"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function userClients(Request $request) {
      $clients = DB::table(DB::raw("view_clients"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function userCompetitors(Request $request) {
      $clients = DB::table(DB::raw("view_competitors"));
      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }

    public function userClientsRoot(Request $request) {

      $data = DB::table(DB::raw("
        (
          select * from clients where head_id is null
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($data);
  
      return $dx->invoke($request);
    }
    public function userCompetitorsRoot(Request $request) {

      $data = DB::table(DB::raw("
        (
          select * from competitors where head_id is null
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($data);
  
      return $dx->invoke($request);
    }

    public function userPackages(Request $request) {

      $packages = DB::table(DB::raw("view_packages"));
      $dx = new \App\Services\DatagridService($packages);
  
      return $dx->invoke($request);
    }
    public function userPackagesReJoin(Request $request) {

      $packages = DB::table(DB::raw("
      (
        select distinct * from view_packages where so_tbmt in (
          select so_tbmt from (
            select tt.*, 
            CASE
                WHEN LOCATE('Ngày', thoi_gian_thuc_hien) > 0 THEN UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(DATE_ADD(STR_TO_DATE(nhan_e_hsdt_den_ngay,'%Y%m%d') , INTERVAL SUBSTRING_INDEX(thoi_gian_thuc_hien, 'Ngày', 1) DAY))
                WHEN LOCATE('Tháng', thoi_gian_thuc_hien) > 0 THEN UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(DATE_ADD(STR_TO_DATE(nhan_e_hsdt_den_ngay,'%Y%m%d') , INTERVAL (SUBSTRING_INDEX(thoi_gian_thuc_hien, 'Tháng', 1)*30) DAY))
                ELSE 0
            END AS is_near
            from thong_tin_goi_thau tt 
            order by tt.so_tbmt desc
            ) temp 
          where is_near > 0 and is_near < 60*60*24*30
					and ten_goi_thau not like '%đầu tư%' and ten_goi_thau not like '%mua%'
					and score_service > 0.4
        )
      ) tmp2"));
      $dx = new \App\Services\DatagridService($packages);
  
      return $dx->invoke($request);
    }
    
    public function detailCompetitorCompetitorStatistic(Request $request) {
      
      $packageYearStats = DB::select(DB::raw("
      select tmp1.year, 
      tmp1.number_packages, 
      tmp2.number_packages_cntt, 
      IFNULL(tmp3.number_packages_competitor1,0) as number_packages_competitor1, 
      tmp3.total_gia_competitor1, 
      IFNULL(tmp4.number_packages_competitor2,0) as number_packages_competitor2, 
      tmp4.total_gia_competitor2 from (
        select count(*) as number_packages, left(so_tbmt,4) as year from (
          select distinct tt.* from thong_tin_goi_thau tt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          join competitors c1 on c1.so_dkkd = bt.so_dkkd 
          join (
            select distinct tt2.* from thong_tin_goi_thau tt2
            join bidder_tender bt2 on bt2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bt2.so_dkkd 
            where c2.so_dkkd = '$request->competitor1_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c1.so_dkkd = '$request->competitor2_mst'
        ) t1
        group by year
      ) tmp1
      left join (
        select count(*) as number_packages_cntt, left(so_tbmt,4) as year from (
          select distinct tt.* from thong_tin_goi_thau tt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          join competitors c1 on c1.so_dkkd = bt.so_dkkd 
          join (
            select distinct tt2.* from thong_tin_goi_thau tt2
            join bidder_tender bt2 on bt2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bt2.so_dkkd 
            where c2.so_dkkd = '$request->competitor1_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c1.so_dkkd = '$request->competitor2_mst'
        ) t1
        where score_service > 0.4
        group by year
      ) tmp2 on tmp2.year = tmp1.year
      left join (
        select count(*) as number_packages_competitor1, SUM(gia_trung_thau) as total_gia_competitor1, left(so_tbmt,4) as year from (
          select distinct tt.* from thong_tin_goi_thau tt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          join competitors c1 on c1.so_dkkd = bt.so_dkkd 
          join (
            select distinct tt2.* from thong_tin_goi_thau tt2
            join bidder_tender bt2 on bt2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bt2.so_dkkd 
            where c2.so_dkkd = '$request->competitor2_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c1.so_dkkd = '$request->competitor1_mst' and tt.competitor_id = c1.so_dkkd
        ) t1
        group by year
      ) tmp3 on tmp3.year = tmp1.year
      left join (
        select count(*) as number_packages_competitor2, SUM(gia_trung_thau) as total_gia_competitor2, left(so_tbmt,4) as year from (
          select distinct tt.* from thong_tin_goi_thau tt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          join competitors c1 on c1.so_dkkd = bt.so_dkkd 
          join (
            select distinct tt2.* from thong_tin_goi_thau tt2
            join bidder_tender bt2 on bt2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bt2.so_dkkd 
            where c2.so_dkkd = '$request->competitor1_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c1.so_dkkd = '$request->competitor2_mst' and tt.competitor_id = c1.so_dkkd
        ) t1
        group by year
      ) tmp4 on tmp4.year = tmp1.year
      "));
      
      $packageYearJoinStats = DB::select(DB::raw("
        select count(*) as number_packages, SUM(gia_trung_thau) as total_gia_doanh_so, SUM(is_win) as number_packages_win, SUM(value_win) as total_gia_trung_thau, year
        from (
          select tt.*,
          CASE
              WHEN tt.competitor_id = '$request->competitor1_mst' THEN 1
              WHEN tt.competitor_id = '$request->competitor2_mst' THEN 1
              ELSE 0
          END is_win,
          CASE
              WHEN tt.competitor_id = '$request->competitor1_mst' THEN gia_trung_thau
              WHEN tt.competitor_id = '$request->competitor2_mst' THEN gia_trung_thau
              ELSE 0
          END value_win, left(tt.so_tbmt,4) as year from thong_tin_goi_thau tt
          join bidder_joint_venture bjv on bjv.so_tbmt = tt.so_tbmt
          join competitors c on c.so_dkkd = bjv.so_dkkd  
          join (
            select tt2.so_tbmt from thong_tin_goi_thau tt2
            join bidder_joint_venture bjv2 on bjv2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bjv2.so_dkkd 
            where c2.so_dkkd = '$request->competitor1_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c.so_dkkd = '$request->competitor2_mst'
        ) temp
        group by year
      "));
      
      $totalPackagesCompetitor1Win = collect($packageYearStats)->sum('number_packages_competitor1');
      $totalPackagesCompetitor2Win = collect($packageYearStats)->sum('number_packages_competitor2');
      $totalValueCompetitor1Win = collect($packageYearStats)->sum('total_gia_competitor1');
      $totalValueCompetitor2Win = collect($packageYearStats)->sum('total_gia_competitor2');
      $totalPackagesJoin = collect($packageYearJoinStats)->sum('number_packages');
      $totalPackagesJoinWin = collect($packageYearJoinStats)->sum('number_packages_win');
      $totalValueJoinWin = collect($packageYearJoinStats)->sum('total_gia_trung_thau');
      $totalValueJoin = collect($packageYearJoinStats)->sum('total_gia_doanh_so');
      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from thong_tin_goi_thau tt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          join competitors c1 on c1.so_dkkd = bt.so_dkkd 
          join (
            select distinct tt2.* from thong_tin_goi_thau tt2
            join bidder_tender bt2 on bt2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bt2.so_dkkd 
            where c2.so_dkkd = '$request->competitor1_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c1.so_dkkd = '$request->competitor2_mst'
        ) tmp2
      "))->get();
      return [
        'totalPackages' => count($packages),
        'totalPackagesJoin' => $totalPackagesJoin,
        'totalPackagesJoinWin' => $totalPackagesJoinWin,
        'totalValueJoin' => $totalValueJoin,
        'totalValueJoinWin' => $totalValueJoinWin,
        'packageYearStats' => $packageYearStats,
        'packageYearJoinStats' => $packageYearJoinStats,
        'totalPackagesCompetitor1Win' => $totalPackagesCompetitor1Win,
        'totalPackagesCompetitor2Win' => $totalPackagesCompetitor2Win,
        'totalValueCompetitor1Win' => $totalValueCompetitor1Win,
        'totalValueCompetitor2Win' => $totalValueCompetitor2Win,
      ];
    }
    public function detailCompetitorCompetitorPackages(Request $request) {
      $competitor1_mst = $request->competitor1_mst;
      $competitor2_mst = $request->competitor2_mst;
      
      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from view_packages tt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          join competitors c1 on c1.so_dkkd = bt.so_dkkd 
          join (
            select distinct tt2.* from view_packages tt2
            join bidder_tender bt2 on bt2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bt2.so_dkkd 
            where c2.so_dkkd = '$request->competitor2_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c1.so_dkkd = '$request->competitor1_mst'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }
    public function userStatisticCity(Request $request) {
      $statistic = DB::select(DB::raw("select * from view_statistic_by_packages_city_cntt"));
      return [
        'statistic' => $statistic,
      ];
    }
    public function userStatisticCityList(Request $request) {
      $condition = "";
      if(isset($request->yearmonth)){
        $condition = " and temp.format_yearmonth = '$request->yearmonth'";
      }
      $packages = DB::table(DB::raw("
        (
          select * from (
            select *, concat(right(yearmonth,2),'/',left(yearmonth,4)) as format_yearmonth, left(yearmonth,4) as year from (
              select tt.*, left(tt.so_tbmt,6) as yearmonth
              from view_packages tt
              where tt.score_service > 0.4 and tt.city = '$request->city'
            ) tmp
          ) temp where temp.year = '$request->year' $condition
        ) tttt
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }
    public function userStatisticCompetitorList(Request $request) {
      $condition = "";
      if(isset($request->yearmonth)){
        $condition = " and temp.format_yearmonth = '$request->yearmonth'";
      }
      $packages = DB::table(DB::raw("
        (
          select * from (
            select *, concat(right(yearmonth,2),'/',left(yearmonth,4)) as format_yearmonth, left(yearmonth,4) as year from (
              select tt.*, left(tt.so_tbmt,6) as yearmonth, c2.id as id_join, c2.name_vi as name_vi_join
              from view_packages tt
              left join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
              left join competitors c2 on c2.so_dkkd = bt.so_dkkd
              where tt.score_service > 0.4 and tt.city = '$request->city'
            ) tmp
          ) temp where temp.year = '$request->year' $condition
        ) tttt
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }
    public function userStatisticProvinces(Request $request) {
      $statistic = DB::select(DB::raw("select * from view_statistic_by_province"));
      return [
        'statistic' => $statistic,
      ];
    }
    public function userStatisticProvincesList(Request $request) {
      $condition = "";
      if(isset($request->linh_vuc)){
        $condition = " and tmp.linh_vuc = '$request->linh_vuc'";
      }
      $packages = DB::table(DB::raw("
        (
          SELECT * FROM (
            SELECT c.id as id_client, c.company_name,`bpd`.*, ifnull( `c`.`city`, 'Khác' ) AS `city`,
              LEFT ( `bpd`.`thoi_gian_to_chuc`, 4 ) AS `year`,
              concat(RIGHT ( `bpd`.`thoi_gian_to_chuc`, 2 ),'/',LEFT (`bpd`.`thoi_gian_to_chuc`, 4 )) AS `format_year` 
            FROM `bidder_plan_details` `bpd`
            LEFT JOIN `bidder_plan_clients` `bpc` ON `bpc`.`so_khlcnt` = `bpd`.`so_khlcnt` 
            LEFT JOIN `clients` `c` ON `c`.`company_id` = `bpc`.`company_id` 
            WHERE `bpd`.`thoi_gian_to_chuc` > 0  and `c`.city = '$request->city'
          ) `tmp` 
          WHERE tmp.format_year = '$request->yearmonth' $condition
        ) temp
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }
    public function userStatisticPackages(Request $request) {
      $statistic = DB::select(DB::raw("
        select * from view_statistic_by_packages_cntt
      "));
      return [
        'statistic' => $statistic,
      ];
    }
    public function userStatisticPackagesList(Request $request) {
      $condition = "";
      if(isset($request->yearmonth)){
        $condition = " and temp.format_yearmonth = '$request->yearmonth'";
      }
      $packages = DB::table(DB::raw("
        (
          select * from (
            select *, concat(right(yearmonth,2),'/',left(yearmonth,4)) as format_yearmonth, left(yearmonth,4) as year from (
              select tt.*, left(tt.so_tbmt,6) as yearmonth
              from view_packages tt
              where tt.score_service > 0.4 and tt.mst_competitor = '$request->competitor_mst'
              order by yearmonth
            ) ttt
          ) temp where temp.year = '$request->year' $condition
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }
    public function userStatisticClients(Request $request) {
      $statistic = DB::select(DB::raw("
        select * from view_statistic_by_clients
      "));
      return [
        'statistic' => $statistic,
      ];
    }

    public function userStatisticClientsList(Request $request) {
      $condition = "";
      if(isset($request->yearmonth)){
        $condition = " and tmp.format_year = '$request->yearmonth'";
      }
      $packages = DB::table(DB::raw("
        (
          SELECT `tmp`.* FROM (
            SELECT `bpd`.*,`c`.`company_name` AS `company_name`,`c`.`id` AS `id_client`,
              LEFT ( `bpd`.`thoi_gian_to_chuc`, 4 ) AS `year`,
              concat(RIGHT ( `bpd`.`thoi_gian_to_chuc`, 2 ),'/',LEFT ( `bpd`.`thoi_gian_to_chuc`, 4 )) AS `format_year` 
            FROM `bidder_plan_details` `bpd`
            LEFT JOIN `bidder_plan_clients` `bpc` ON `bpc`.`so_khlcnt` = `bpd`.`so_khlcnt` 
            LEFT JOIN `clients` `c` ON `c`.`company_id` = `bpc`.`company_id` 
            WHERE `bpd`.`thoi_gian_to_chuc` > 0 and `c`.so_dkkd = '$request->client_mst'
          ) `tmp` 
          WHERE `tmp`.`year` = date_format(now(), '%Y') $condition
        ) temp
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }

    public function detailCompetitorCompetitorPackagesJoin(Request $request) {
      $competitor1_mst = $request->competitor1_mst;
      $competitor2_mst = $request->competitor2_mst;
      
      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from view_packages tt
          join bidder_joint_venture bjv on bjv.so_tbmt = tt.so_tbmt
          join competitors c on c.so_dkkd = bjv.so_dkkd  
          join (
            select distinct tt2.so_tbmt from view_packages tt2
            join bidder_joint_venture bjv2 on bjv2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bjv2.so_dkkd 
            where c2.so_dkkd = '$competitor1_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c.so_dkkd = '$competitor2_mst'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }

    public function detailCompetitorCompetitorPackagesWin(Request $request) {
      $competitor1_mst = $request->competitor1_mst;
      $competitor2_mst = $request->competitor2_mst;
      
      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from view_packages tt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          join competitors c1 on c1.so_dkkd = bt.so_dkkd 
          join (
            select distinct tt2.* from view_packages tt2
            join bidder_tender bt2 on bt2.so_tbmt = tt2.so_tbmt
            join competitors c2 on c2.so_dkkd = bt2.so_dkkd 
            where c2.so_dkkd =' $request->competitor2_mst'
          ) t2 on t2.so_tbmt = tt.so_tbmt
          where c1.so_dkkd = '$request->competitor1_mst' and tt.competitor_id = c1.so_dkkd
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }

    public function detailClientCompetitorStatistic(Request $request) {
      $packageYearStats = DB::select(DB::raw("
          select * from (
            select COUNT(*) as number_packages, left(so_tbmt,4) as year from (
              select distinct tt.* from thong_tin_goi_thau tt
              join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
              join clients c on c.company_id = tt.company_id
              join competitors c2 on c2.so_dkkd = bt.so_dkkd
              where c2.so_dkkd = '$request->competitor_mst' and c.so_dkkd = '$request->client_mst'
            ) tmp
            group by year
          ) tmp3
          left join (
            select COUNT(*) as number_wins, left(so_tbmt,4) as year from (
              select tt.* from thong_tin_goi_thau tt
              join clients c on c.company_id = tt.company_id
              join competitors c2 on c2.so_dkkd = tt.competitor_id
              where c2.so_dkkd = '$request->competitor_mst' and c.so_dkkd = '$request->client_mst'
            ) a
            group by year
          ) tmp4 on tmp4.year = tmp3.year
      "));
      $totalPackages = collect($packageYearStats)->sum('number_packages');
      $totalPackagesWin = collect($packageYearStats)->sum('number_wins');
      return [
        'totalPackages' => $totalPackages,
        'totalPackagesWin' => $totalPackagesWin,
        'packageYearStats' => $packageYearStats,
      ];
    }
    public function detailClientCompetitorPackages(Request $request) {
      $client_mst = $request->client_mst;
      $competitor_mst = $request->competitor_mst;
      
      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from view_packages tt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          where tt.mst_client = '$request->client_mst' and bt.so_dkkd = '$request->competitor_mst'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }
    public function detailClientCompetitorPackagesWin(Request $request) {
      $client_mst = $request->client_mst;
      $competitor_mst = $request->competitor_mst;
      
      $packages = DB::table(DB::raw("
        (
          select tt.* from view_packages tt
          where tt.mst_client = '$request->client_mst' and tt.mst_competitor = '$request->competitor_mst'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }


    public function detailPackagesStatistic(Request $request) {
      $hsmtData = DB::select(DB::raw("
        select tmp1.notifyId, tmp1.bidNo, biccl.notifyNo, biccl.pcode, biccl.code, biccl.name, biccl.description, biccl.lev
        from `muasamcong_v2`.bidaInvChapterConfList biccl
        left join (
          select distinct notifyId, notifyNo, bidNo from `muasamcong_v2`.bidoInvBiddingDTO
        ) tmp1 on tmp1.notifyNo = biccl.notifyNo
        where tmp1.notifyNo = '$request->so_tbmt'  order by pcode asc, code asc
      "));

      $chartData = DB::select(DB::raw("
        select bt.gia_du_thau, bt.gia_sau_giam,  c.name_vi, bt.thoi_gian_thuc_hien, c.id as id_competitor 
        from `thong_tin_goi_thau` tt
        left join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
        left join `competitors` c on c.`so_dkkd` = bt.`so_dkkd`
        where tt.so_tbmt = '$request->so_tbmt'
      "));

      $competitors = DB::table('competitors')
      ->join('bidder_tender', 'bidder_tender.so_dkkd', '=', 'competitors.so_dkkd')
      ->join('thong_tin_goi_thau', 'thong_tin_goi_thau.so_tbmt', '=', 'bidder_tender.so_tbmt')
      ->selectRaw("bidder_tender.gia_du_thau, thong_tin_goi_thau.gia_trung_thau")
      ->where("thong_tin_goi_thau.so_tbmt",$request->so_tbmt)->get();
      $totalCompetitors = collect($competitors)->count();
      return [
        'totalCompetitors' => $totalCompetitors,
        'chartData' => $chartData,
        'hsmtData' => $hsmtData,
      ];
    }
    public function detailPackagesCompetitors(Request $request) {
      $clients = DB::table('competitors')
      ->join('bidder_tender', 'bidder_tender.so_dkkd', '=', 'competitors.so_dkkd')
      ->selectRaw("bidder_tender.gia_du_thau, competitors.*")
      ->distinct()->whereRaw("so_tbmt in (
        select tt.so_tbmt from thong_tin_goi_thau tt
        where tt.so_tbmt = '$request->so_tbmt'
      )");
      // dd($clients->toSql());
      $dx = new \App\Services\DatagridService($clients);
      return $dx->invoke($request);
    }

    public function detailClientsPlans(Request $request) {
      $packages = DB::table(DB::raw("
        (
          select bpt.* from bidder_plan_table bpt
          left join `bidder_plan_clients` bpc on bpc.so_khlcnt = bpt.`so_khlcnt`
          left join `clients` c on c.`company_id` = bpc.`company_id`
          where c.so_dkkd = '$request->mst'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
  
      return $dx->invoke($request);
    }
    public function detailClientsPackages(Request $request) {
      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from view_packages tt where mst_client = '$request->mst'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
  
      return $dx->invoke($request);
    }
    public function detailPlansPackages(Request $request) {
      $packages = DB::table(DB::raw("
        (
          select bpd.* from bidder_plan_details bpd
          join bidder_plan_table bpt on bpt.so_khlcnt = bpd.so_khlcnt
          where bpt.so_khlcnt = '$request->so_khlcnt'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
  
      return $dx->invoke($request);
    }
    
    public function detailClientsChilds(Request $request) {
      $childs = DB::table(DB::raw("
        (
          WITH RECURSIVE cte_name  AS (
            SELECT c.id, c.company_name, c.city, c.address, c.so_dkkd, c.created_date, 1 as level FROM clients as c 
            left join clients c1 on c1.id = c.head_id 
            WHERE c.so_dkkd = '$request->mst'
            UNION ALL
            SELECT c2.id, c2.company_name, c2.city, c2.address, c2.so_dkkd, c2.created_date, p.level+1 as level FROM cte_name p JOIN clients c2 ON p.id = c2.head_id
          )
          SELECT * FROM cte_name ORDER BY id
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($childs);
      return $dx->invoke($request);
    }
    public function detailClientsStatistic(Request $request) {
      
      $packageYearStats = DB::select(DB::raw("
        select * from (
          select COUNT(*) as number_total, sum(gia_trung_thau) as total_quy_mo, left(tt.so_tbmt,4) as year
          from thong_tin_goi_thau tt
          where tt.company_id in (
            select company_id from clients cli
            where cli.so_dkkd =   '$request->mst'
          ) 
          group by year
        ) tmp1
        left join (
          select COUNT(*) as number_cntt, sum(gia_trung_thau) as total_quy_mo_cntt, left(tt.so_tbmt,4) as year
          from thong_tin_goi_thau tt
          where tt.company_id in (
            select company_id from clients cli
            where cli.so_dkkd =   '$request->mst'
          ) 
          and tt.score_service > 0.4
          group by year

          
        ) tmp2 on tmp2.year = tmp1.year
        order by tmp1.year asc
      "));
      
      $packageCompetitorStats = DB::select(DB::raw("
          select c.*, count(*) as number_packages from `competitors` c 
          inner join `bidder_tender` on `bidder_tender`.`so_dkkd` = c.`so_dkkd` 
          where so_tbmt in (
            select tt.so_tbmt from thong_tin_goi_thau tt
            join clients cli on cli.company_id = tt.company_id
            where cli.so_dkkd =   '$request->mst'
          )
          group by c.id
      "));

      $totalPackagesCNTT = collect($packageYearStats)->sum('number_cntt');
      $totalPackages = collect($packageYearStats)->sum('number_total');
      $totalPackagesCNTTValue = collect($packageYearStats)->sum('total_quy_mo_cntt');
      $totalPackagesValue = collect($packageYearStats)->sum('total_quy_mo');

      $packageTypeStats = DB::select(DB::raw("
        select COUNT(*) as total, score_service > 0.4 as is_cntt from thong_tin_goi_thau tt
        where tt.company_id in (
          select company_id from clients cli
          where cli.so_dkkd =   '$request->mst'
        ) 
        group by is_cntt
      "));
      $ret = [];
      foreach ($packageTypeStats as $val) {
        if($val->is_cntt == 0){
          array_push($ret, (object)['total' => $val->total, 'group' => 'Viễn thông & CNTT']);
        }else{
          array_push($ret, (object)['total' => $val->total, 'group' => 'Khác']);
        }
      }
      return [
        'packageYearStats' => $packageYearStats,
        'totalPackages' => $totalPackages,
        'totalPackagesCNTT' => $totalPackagesCNTT,
        'totalPackagesValue' => $totalPackagesValue,
        'totalPackagesCNTTValue' => $totalPackagesCNTTValue,
        'packageCompetitorStats' => $packageCompetitorStats,
      ];
    }
    public function detailClientsCompetitors(Request $request) {

      $competitors = DB::table(DB::raw("
        (
          select * from (
            select c.*, count(*) as number_packages from `competitors` c 
            inner join `bidder_tender` on `bidder_tender`.`so_dkkd` = c.`so_dkkd` 
            where so_tbmt in (
              select tt.so_tbmt from thong_tin_goi_thau tt
              join clients cli on cli.company_id = tt.company_id
              where cli.so_dkkd = '$request->mst'
            )
            group by c.id
          ) tmp1
          left join(
            select count(*) as number_wins, tt.competitor_id from thong_tin_goi_thau tt
            join clients cli on cli.company_id = tt.company_id
            where cli.so_dkkd = '$request->mst'
            group by tt.competitor_id
          ) tmp2 on tmp1.so_dkkd = tmp2.competitor_id
        ) temp2
      "));
      $dx = new \App\Services\DatagridService($competitors);
      return $dx->invoke($request);
    }
    public function detailClientsGood(Request $request) {

      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from view_packages tt where mst_competitor = '$request->mst'
        ) tmp2
      "));
      return $dx->invoke($request);
    }
    public function detailCompetitorsJoins(Request $request) {
      $competitors = DB::table(DB::raw("
        (
          select c2.*, count(*) as number_packages from bidder_joint_venture bjv
          join thong_tin_goi_thau tt on tt.so_tbmt = bjv.so_tbmt
          join bidder_tender bt on bt.so_tbmt = tt.so_tbmt
          join competitors c on c.so_dkkd = bt.so_dkkd
          join competitors c2 on c2.so_dkkd = bjv.so_dkkd
          where c.so_dkkd = '$request->mst' and bjv.so_dkkd <> c.so_dkkd
          group by c2.id
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($competitors);
      return $dx->invoke($request);
    }

    public function detailCompetitorsPackages(Request $request) {
      
      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from view_packages tt where tt.so_tbmt in (
            select bt2.so_tbmt from bidder_tender bt2
            join competitors com2 on com2.so_dkkd = bt2.so_dkkd
            where com2.so_dkkd =   '$request->mst'
          )
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
  
      return $dx->invoke($request);
    }
    public function detailCompetitorsPackagesWin(Request $request) {
      $packages = DB::table(DB::raw("
        (
          select distinct tt.* from view_packages tt where mst_competitor = '$request->mst'
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($packages);
  
      return $dx->invoke($request);
    }
    public function detailCompetitorsPackagesClients(Request $request) {
      
      $clients = DB::table(DB::raw("
        (select count(1) as number_packages, clients.* from `competitors` 
        inner join `bidder_tender` on `bidder_tender`.`so_dkkd` = `competitors`.`so_dkkd` 
        inner join `thong_tin_goi_thau` on `thong_tin_goi_thau`.`so_tbmt` = `bidder_tender`.`so_tbmt` 
        inner join `clients` on `clients`.`company_id` = `thong_tin_goi_thau`.`company_id` where `competitors`.`so_dkkd` = '$request->mst'
        group by `clients`.`id`) as tmp
      "));

      $dx = new \App\Services\DatagridService($clients);
  
      return $dx->invoke($request);
    }
    public function detailCompetitorsStatistic(Request $request) {
      $packageYearStats = DB::select(DB::raw("
        select * from (
          select COUNT(*) as number_cntt, sum(gia_trung_thau) as total_quy_mo_tham_du_cntt, left(tt.so_tbmt,4) as year
          from thong_tin_goi_thau tt
          where tt.so_tbmt in (
            select bt2.so_tbmt from bidder_tender bt2
            join competitors cli on cli.so_dkkd = bt2.so_dkkd
            where cli.so_dkkd =   '$request->mst'
          ) 
          and tt.score_service > 0.4
          group by year
        ) tmp1
        left join (
          select COUNT(*) as number_total, sum(gia_trung_thau) as total_quy_mo_tham_du, left(tt.so_tbmt,4) as year
          from thong_tin_goi_thau tt
          where tt.so_tbmt in (
            select bt2.so_tbmt from bidder_tender bt2
            join competitors cli on cli.so_dkkd = bt2.so_dkkd
            where cli.so_dkkd =   '$request->mst'
          ) 
          group by year
        ) tmp2 on tmp2.year = tmp1.year
        left join (
          select COUNT(*) as number_win, sum(gia_trung_thau) as total_gia_trung_thau, left(tt.so_tbmt,4) as year
          from thong_tin_goi_thau tt
          join competitors cli on cli.so_dkkd = tt.competitor_id
          where cli.so_dkkd =   '$request->mst'
          group by year
        ) tmp3 on tmp3.year = tmp1.year
        left join (
          select COUNT(*) as number_cntt_win, sum(gia_trung_thau) as total_gia_trung_thau_cntt, left(tt.so_tbmt,4) as year
          from thong_tin_goi_thau tt
          join competitors cli on cli.so_dkkd = tt.competitor_id
          where cli.so_dkkd =   '$request->mst'
          and tt.score_service > 0.4
          group by year
        ) tmp4 on tmp4.year = tmp1.year
        order by tmp1.year asc
      "));
      
      $packageCompetitorStats = DB::select(DB::raw("
        select count(1) as number_packages, left(`bidder_tender`.so_tbmt,4) as year, clients.* from `competitors` 
        inner join `bidder_tender` on `bidder_tender`.`so_dkkd` = `competitors`.`so_dkkd` 
        inner join `thong_tin_goi_thau` on `thong_tin_goi_thau`.`so_tbmt` = `bidder_tender`.`so_tbmt` 
        inner join `clients` on `clients`.`company_id` = `thong_tin_goi_thau`.`company_id` where `competitors`.`so_dkkd` =   '$request->mst'
        group by `clients`.`id`, year
      "));
      
      $totalPackages = collect($packageYearStats)->sum('number_total');
      $totalPackagesWin = collect($packageYearStats)->sum('number_win');
      $totalPackagesCNTT = collect($packageYearStats)->sum('number_cntt');
      $totalPackagesCNTTWin = collect($packageYearStats)->sum('number_cntt_win');

      $totalPackagesValue = collect($packageYearStats)->sum('total_quy_mo_tham_du');
      $totalPackagesValueThamDuCNTT = collect($packageYearStats)->sum('total_quy_mo_tham_du_cntt');
      $totalPackagesValueTrungThau = collect($packageYearStats)->sum('total_gia_trung_thau');
      $totalPackagesValueTrungThauCNTT = collect($packageYearStats)->sum('total_gia_trung_thau_cntt');

      $packageTypeStats = DB::select(DB::raw("
        select COUNT(*) as total, score_service > 0.4 as is_cntt from thong_tin_goi_thau tt
        where tt.so_tbmt in (
          select bt2.so_tbmt from bidder_tender bt2
          join competitors com2 on com2.so_dkkd = bt2.so_dkkd
          where com2.so_dkkd =   '$request->mst'
        ) 
        group by is_cntt
      "));
      $ret = [];
      foreach ($packageTypeStats as $val) {
        if($val->is_cntt == 0){
          array_push($ret, (object)['total' => $val->total, 'group' => 'Viễn thông & CNTT']);
        }else{
          array_push($ret, (object)['total' => $val->total, 'group' => 'Khác']);
        }
      }
      return [
        'packageTypeStats' => $ret,
        'packageYearStats' => $packageYearStats,
        'packageCompetitorStats' => $packageCompetitorStats,
        'totalPackages' => $totalPackages,
        'totalPackagesWin' => $totalPackagesWin,
        'totalPackagesCNTT' => $totalPackagesCNTT,
        'totalPackagesCNTTWin' => $totalPackagesCNTTWin,
        'totalPackagesValue' => $totalPackagesValue,
        'totalPackagesValueThamDuCNTT' => $totalPackagesValueThamDuCNTT,
        'totalPackagesValueTrungThau' => $totalPackagesValueTrungThau,
        'totalPackagesValueTrungThauCNTT' => $totalPackagesValueTrungThauCNTT,
      ];
    }

    public function detailCompetitorsChilds(Request $request) {
      $childs = DB::table(DB::raw("
        (
            WITH RECURSIVE cte_name  AS (
              SELECT c.id, c.name_vi, c.c_address, c.province, c.so_dkkd, 1 as level FROM competitors as c 
              left join competitors c1 on c1.id = c.head_id 
              WHERE c1.so_dkkd = '$request->mst'
              UNION ALL
              SELECT c2.id, c2.name_vi,c2.c_address, c2.province, c2.so_dkkd, p.level+1 as level FROM cte_name p JOIN competitors c2 ON p.id = c2.head_id
            )
            SELECT * FROM cte_name ORDER BY id
        ) tmp2
      "));
      $dx = new \App\Services\DatagridService($childs);
      return $dx->invoke($request);
    }

    public function detailCompetitorsCompetitors(Request $request) {
      $competitors = DB::table('competitors')
      ->selectRaw("competitors.*, count(1) as number_packages")
      ->join('bidder_tender', 'bidder_tender.so_dkkd', '=', 'competitors.so_dkkd')
      ->distinct()
      ->whereRaw("so_tbmt in (
          select bt2.so_tbmt from bidder_tender bt2
          join competitors com2 on com2.so_dkkd = bt2.so_dkkd
          where com2.so_dkkd = '$request->mst'
      ) and competitors.so_dkkd <> '$request->mst'")
      ->groupBy("competitors.id");
      // dd($competitors->toSql());
      $dx = new \App\Services\DatagridService($competitors);
      return $dx->invoke($request);
    }
    public function detailCompetitorsGood(Request $request) {
      $packages = DB::table('thong_tin_goi_thau');
      // if(isset($request->id)){
      //   $packages = $packages->where('competitor_id', $request->id);
      // }
      $dx = new \App\Services\DatagridService($packages);
      return $dx->invoke($request);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      return redirect('/dashboard/packages');
    }
    public function favorites(Request $request) {
      DB::table('favorites')->insert([
        'type' =>$request->type,
        'record_id' =>$request->id,
      ]);
      return response()->json([
        'status' => 'ok'
      ]);
    }
}
