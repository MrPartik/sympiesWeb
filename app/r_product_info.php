<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $PROD_ID
 * @property int $PRODT_ID
 * @property int $AFF_ID
 * @property int $TAXP_ID
 * @property string $PROD_COLOR
 * @property string $PROD_DESC
 * @property string $PROD_NOTE
 * @property string $PROD_SIZE
 * @property string $PROD_IMG
 * @property float $PROD_REBATE
 * @property float $PROD_MARKUP
 * @property string $PROD_CODE
 * @property string $PROD_NAME
 * @property integer $PROD_QTY
 * @property integer $PROD_CRITICAL
 * @property float $PROD_BASE_PRICE
 * @property boolean $PROD_IS_APPROVED
 * @property string $PROD_APPROVED_AT
 * @property boolean $PROD_DISPLAY_STATUS
 * @property string $created_at
 * @property string $updated_at
 * @property RAffiliateInfo $rAffiliateInfo
 * @property RProductType $rProductType
 * @property RTaxTableProfile $rTaxTableProfile
 */
class r_product_info extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'R_PRODUCT_INFOS';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'PROD_ID';

    /**
     * @var array
     */
    protected $fillable = ['PRODT_ID', 'AFF_ID', 'TAXP_ID', 'PROD_DESC', 'PROD_NOTE', 'PROD_IMG', 'PROD_REBATE', 'PROD_MARKUP', 'PROD_CODE', 'PROD_NAME', 'PROD_QTY','PROD_CRITICAL','PROD_BASE_PRICE', 'PROD_IS_APPROVED','PROD_APPROVED_AT', 'PROD_DISPLAY_STATUS', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rAffiliateInfo()
    {
        return $this->belongsTo(r_affiliate_info::class, 'AFF_ID', 'AFF_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rProductType()
    {
        return $this->belongsTo(r_product_type::class, 'PRODT_ID', 'PRODT_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rTaxTableProfile()
    {
        return $this->belongsTo(r_tax_table_profile::class, 'TAXP_ID', 'TAXP_ID');
    }
}
