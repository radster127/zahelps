<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_type', 'user_id', 'username', 'password', 'ip_address',
      'name', 'email', 'phone', 'avatar', 'address', 'city', 'pincode', 'country_id',
      'bank_name', 'bank_account_name', 'bank_account_number', 'bitcoin', 'referals',
      'joining_datetime', 'last_login_datetime', 'last_login_ip_address', 'suspended',
      'facebook', 'twitter', 'account_balance', 'admin_commision', 'member_commision', 'current_ph',
      'status', 'newsletter'
  ];
  protected $table = 'users';

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

  public function isActive() {
    return $this->attributes['status'] == "active" ? true : false;
  }

  public function country() {
    return $this->belongsTo('\App\Country');
  }

  public function sponsor() {
    return $this->belongsTo('\App\User', 'user_id');
  }

  public function manager() {
    return $this->belongsTo('\App\Manager', 'manager_id');
  }

  protected $searchColumns = [
      'all' => 'All',
      'users.username' => 'Username',
      'users.name' => 'Full Name',
      'users.email' => 'Email',
      'users.mobile' => 'Mobile',
  ];

  public function getSearchColumns() {
    return $this->searchColumns;
  }

  public function getAdminList($params) {
    $searchField = isset($params['search_field']) ? trim($params['search_field']) : '';
    $searchText = isset($params['search_text']) ? trim($params['search_text']) : '';
    $from_date = isset($params['from_date']) ? trim($params['from_date']) : '';
    $to_date = isset($params['to_date']) ? trim($params['to_date']) : '';
    $sortBy = isset($params['sort_by']) ? $params['sort_by'] : '';
    $sortOrd = isset($params['sort_order']) ? $params['sort_order'] : 'DESC';


    if (isset($params['suspended'])) {
      $query = $this->where('suspended', '=', '1');
    } else {
      $query = $this->where('suspended', '=', '0');
    }

    if (isset($params['manager_id']) && $params['manager_id'] > 0) {
      $query->where('manager_id', '=', $params['manager_id']);
    }

    // filter query 

    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {
        $query->whereRaw(
                "(
                                    (" . $this->table . ".username LIKE '%" . $searchText . "%') OR
                                    (" . $this->table . ".name LIKE '%" . $searchText . "%') OR
                                    (" . $this->table . ".email LIKE '%" . $searchText . "%') OR
                                    (" . $this->table . ".phone LIKE '%" . $searchText . "%')
                                )");
      } else {
        $query->where($searchField, 'LIKE', '%' . $searchText . '%');
      }
    }


    if ($from_date != "") {
      $from_date = \Carbon\Carbon::createFromFormat('m/d/Y', $from_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(" . $this->table . ".created_at, '%Y-%m-%d') >= '$from_date'");
    }

    if ($to_date != "") {
      $to_date = \Carbon\Carbon::createFromFormat('m/d/Y', $to_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(" . $this->table . ".created_at, '%Y-%m-%d') <= '$to_date'");
    }

    // sort query
    if ($sortBy != "" && $sortOrd != "") {
      $query->orderBy($sortBy, $sortOrd);
    } else {
      $query->orderBy($this->table . '.id', 'DESC');
    }



    $record_per_page = (isset($params['record_per_page']) && $params['record_per_page'] != "" && $params['record_per_page'] > 0) ? $params['record_per_page'] : env('APP_RECORDS_PER_PAGE', 1);
    return $query->paginate($record_per_page);
  }

  public static function pendingDirectors($minDownLine = 10) {

    $query = DB::table('users AS u1');

    return $query->leftJoin('users AS u2', 'u1.user_id', '=', 'u2.id')
                    ->where('u2.manager_id', '=', NULL)
                    ->select(['u2.*', DB::raw('count(u1.user_id) AS counter')])
                    ->groupBy('u1.user_id')
                    ->having('counter', '>', $minDownLine)
                    ->get();
  }

  public static function pendingSrDirectors($minDownLine = 10) {

    $query = DB::table('users AS u1');

    return $query->leftJoin('users AS u2', 'u1.user_id', '=', 'u2.id')
                    ->where('u2.manager_id', '=', '1')
                    ->where('u1.manager_id', '=', '1')
                    ->select(['u2.*', DB::raw('count(u1.user_id) AS counter')])
                    ->groupBy('u1.user_id')
                    ->having('counter', '>', $minDownLine)
                    ->get();
  }

  public static function pendingPrincipalDirectors($minDownLine) {

    $query = DB::table('users AS u1');

    return $query->leftJoin('users AS u2', 'u1.user_id', '=', 'u2.id')
                    ->where('u2.manager_id', '=', '2')
                    ->where('u1.manager_id', '=', '2')
                    ->select(['u2.*', DB::raw('count(u1.user_id) AS counter')])
                    ->groupBy('u1.user_id')
                    ->having('counter', '>', $minDownLine = 10)
                    ->get();
  }

  public static function pendingChiefDirectors($minDownLine = 10) {

    $query = DB::table('users AS u1');

    return $query->leftJoin('users AS u2', 'u1.user_id', '=', 'u2.id')
                    ->where('u2.manager_id', '=', '3')
                    ->where('u1.manager_id', '=', '3')
                    ->select(['u2.*', DB::raw('count(u1.user_id) AS counter')])
                    ->groupBy('u1.user_id')
                    ->having('counter', '>', $minDownLine)
                    ->get();
  }
}
