<?php 
namespace App\Exports;

use App\Models\Product\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
     * Menentukan data yang akan diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::leftJoin('variations', 'products.id', '=', 'variations.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('categories as sub_categories', 'products.subcategory', '=', 'sub_categories.id')
            ->join('units', 'products.unit_id', '=', 'units.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                'categories.id as category_id',
                'categories.name as category',
                'brands.id as brand_id',
                'brands.name as brand',
                'sub_categories.name as sub_category',
                'units.id as unit_id',
                'units.name as unit',
                'variations.id as variant_id',
                'variations.name as variant_name',
                'variations.sku as variant_sku',
                'variations.selling_price as selling_price',
                'variations.purchase_price as purchase_price',
                'products.created_at',
                'products.updated_at'
            )
            ->get();
    }

    /**
     * Menentukan judul kolom pada file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'SKU',
            'Category ID',
            'Category',
            'Brand ID',
            'Brand',
            'Sub Category',
            'Unit ID',
            'Unit',
            'Variant ID',
            'Variant Name',
            'Variant SKU',
            'Selling Price',
            'Purchase Price',
            'Created At',
            'Updated At',
        ];
    }
}
