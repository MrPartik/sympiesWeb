<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ORDI_ID
 * @property int $ORD_ID
 * @property int $PROD_ID
 * @property int $ORDI_QTY
 * @property float $ORDI_SOLD_PRICE
 * @property string $ORDI_VOUCHER_CODE
 * @property string $created_at
 * @property string $updated_at
 * @property TOrder $tOrder
 * @property RProductInfo $rProductInfo
 */
class t_order_item extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'T_ORDER_ITEMS';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ORDI_ID';

    /**
     * @var array
     */
    protected $fillable = ['ORD_ID', 'PROD_ID', 'ORDI_QTY', 'ORDI_SOLD_PRICE', 'ORDI_VOUCHER_CODE', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tOrder()
    {
        return $this->belongsTo(t_order::class, 'ORD_ID', 'ORD_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rProductInfo()
    {
        return $this->belongsTo(r_product_info::class, 'PROD_ID', 'PROD_ID');
    }
}
