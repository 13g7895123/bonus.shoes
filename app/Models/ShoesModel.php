<?php

namespace App\Models;

use CodeIgniter\Model;

class ShoesModel extends Model
{
    protected $table            = 'shoes_show_inf';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'images',
        'eng_name',
        'code',
        'hope_price',
        'price',
        'point',
        'size',
        'action'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'eng_name'    => 'permit_empty|max_length[255]',
        'code'        => 'permit_empty|max_length[100]',
        'hope_price'  => 'permit_empty|decimal',
        'price'       => 'permit_empty|decimal',
        'point'       => 'permit_empty|integer',
        'size'        => 'permit_empty|max_length[50]',
        'action'      => 'permit_empty|in_list[新增,更新,刪除]'
    ];
    protected $validationMessages   = [
        'eng_name' => [
            'max_length' => '英文名稱不能超過 255 個字元'
        ],
        'code' => [
            'max_length' => '商品代碼不能超過 100 個字元'
        ],
        'hope_price' => [
            'decimal' => '希望價格必須是數字'
        ],
        'price' => [
            'decimal' => '價格必須是數字'
        ],
        'point' => [
            'integer' => '點數必須是整數'
        ],
        'size' => [
            'max_length' => '尺寸不能超過 50 個字元'
        ],
        'action' => [
            'in_list' => '動作必須是：新增、更新或刪除'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    /**
     * 根據動作類型取得資料
     */
    public function getByAction(string $action): array
    {
        return $this->where('action', $action)->findAll();
    }

    /**
     * 根據商品代碼取得資料
     */
    public function getByCode(string $code): ?array
    {
        return $this->where('code', $code)->first();
    }

    /**
     * 搜尋鞋子
     */
    public function search(array $params): array
    {
        $builder = $this->builder();

        if (!empty($params['eng_name'])) {
            $builder->like('eng_name', $params['eng_name']);
        }

        if (!empty($params['code'])) {
            $builder->like('code', $params['code']);
        }

        if (!empty($params['action'])) {
            $builder->where('action', $params['action']);
        }

        if (!empty($params['min_price'])) {
            $builder->where('price >=', $params['min_price']);
        }

        if (!empty($params['max_price'])) {
            $builder->where('price <=', $params['max_price']);
        }

        return $builder->get()->getResultArray();
    }
}
