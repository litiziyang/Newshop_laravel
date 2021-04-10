<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAddress
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress query()
 * @mixin \Eloquent
 * @property int                             $id            ID
 * @property int                             $user_id       用户ID[该地址所属的用户]
 * @property string                          $province      省
 * @property string                          $city          市
 * @property string                          $district      区
 * @property string                          $address       详细地址
 * @property int                             $zip           邮编
 * @property string                          $contact_name  联系人姓名
 * @property string                          $contact_phone 联系人电话
 * @property string|null                     $last_used_at  最后一次使用时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereZip($value)
 */
class UserAddress extends Model
{
    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at',
    ];

    /**
     * 追加到模型数组表单的访问器。
     *
     * @var array
     */
    protected $appends = ['full_address'];


    protected $dates = ['last_used_at'];

    /**
     * 获取完整地址属性
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
