<?php

class ProductDAL extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'products';
        $this->fields = array(
            'id',
            'name',
            'price',
            'amount',
            'shortDesc',
            'detailDesc',
            'imageUrl',
            'created_at',
            'deleted_at',
            'user_id',
            'ram_id',
            'rom_id',
            'color_id',
            'category_id',
            'status_id'
        );
    }

    public function getObject($value = '0', $condition = '1>0', $key = 'id', $fields = '*')
    {
        $result = $this->select($fields, "{$key} = {$value} AND {$condition}");
        if ($result) {
            $object = new ProductDTO(
                $result[0]['id'],
                $result[0]['name'],
                $result[0]['price'],
                $result[0]['amount'],
                $result[0]['shortDesc'],
                $result[0]['detailDesc'],
                $result[0]['imageUrl'],
                $result[0]['created_at'],
                $result[0]['deleted_at'],
                $result[0]['user_id'],
                $result[0]['ram_id'],
                $result[0]['rom_id'],
                $result[0]['color_id'],
                $result[0]['category_id'],
                $result[0]['status_id'],
            );
            return $object;
        }
        return 0;
    }


    public function getObjects($page_current = 1, $condition = '1>0', $itemPerPage = '')
    {
        $start = '0';
        if (!empty($itemPerPage)) {
            $start = ($page_current - 1) * $itemPerPage;
        }
        $results = $this->select('*', $condition, $start, $itemPerPage);
        if ($results) {
            $objects = array();
            foreach ($results as $key => $result) {
                $objects[] = new ProductDTO(
                    $result['id'],
                    $result['name'],
                    $result['price'],
                    $result['amount'],
                    $result['shortDesc'],
                    $result['detailDesc'],
                    $result['imageUrl'],
                    $result['created_at'],
                    $result['deleted_at'],
                    $result['user_id'],
                    $result['ram_id'],
                    $result['rom_id'],
                    $result['color_id'],
                    $result['category_id'],
                    $result['status_id'],
                );
            }
            return $objects;
        }
        return 0;
    }

    public function addProduct(ProductDTO $productDTO)
    {
        $data = [
            'id' => $productDTO->getId(),
            'name' => $productDTO->getName(),
            'price' => $productDTO->getPrice(),
            'amount' => $productDTO->getAmount(),
            'shortDesc' => $productDTO->getShortDesc(),
            'detailDesc' => $productDTO->getDetailDesc(),
            'imageUrl' => $productDTO->getImageUrl(),
            'created_at' => $productDTO->getCreatedAt(),
            'deleted_at' => $productDTO->getDeletedAt(),
            'user_id' => $productDTO->getUserId(),
            'ram_id' => $productDTO->getRamId(),
            'rom_id' => $productDTO->getRomId(),
            'color_id' => $productDTO->getColorId(),
            'category_id' => $productDTO->getCategoryId(),
            'status_id' => $productDTO->getStatusId()
        ];
        $result = $this->add($data);
        if ($result)
            return $result;
        return 0;
    }

    public function updateProduct(ProductDTO $productDTO)
    {
        $data = array(
            'name' => $productDTO->getName(),
            'price' => $productDTO->getPrice(),
            'amount' => $productDTO->getAmount(),
            'shortDesc' => $productDTO->getShortDesc(),
            'detailDesc' => $productDTO->getDetailDesc(),
            'imageUrl' => $productDTO->getImageUrl(),
            'created_at' => $productDTO->getCreatedAt(),
            'deleted_at' => $productDTO->getDeletedAt(),
            'user_id' => $productDTO->getUserId(),
            'ram_id' => $productDTO->getRamId(),
            'rom_id' => $productDTO->getRomId(),
            'color_id' => $productDTO->getColorId(),
            'category_id' => $productDTO->getCategoryId(),
            'status_id' => $productDTO->getStatusId()
        );
        $result = $this->update($data, "id = '{$productDTO->getId()}'");
        if ($result)
            return $result;
        return 0;
    }

    public function updateAmount($productID, $newAmount){
        $data = array(
            'amount' => $newAmount
        );
        $result = $this->update($data, "id = '{$productID}'");
        if ($result)
            return $result;
        return 0;
    }

    public function deleteProduct(ProductDTO $productDTO)
    {
        $timeCurrent = Date('Y-m-d H:i:s', time());
        $productDTO->setDeletedAt($timeCurrent);
        return $this->updateProduct($productDTO);
    }

    public function deleteAll($list_id)
    {
        if (is_array($list_id)) {
            foreach ($list_id as $id) {
                $productDTO = $this->getObject("'{$id}'");
                $this->deleteProduct($productDTO);
            }
        }
    }

    public function restore(ProductDTO $productDTO)
    {
        $productDTO->setDeletedAt(NULL);
        $this->updateProduct($productDTO);
    }

    public function restoreAll($list_id)
    {
        if (is_array($list_id)) {
            foreach ($list_id as $id) {
                $productDTO = $this->getObject("'{$id}'");
                $this->restore($productDTO);
            }
        }
    }

    public function forceDelete($id)
    {
        return $this->delete("id = '{$id}'");
    }

    public function forceDeleteAll($list_id)
    {
        foreach ($list_id as $id) {
            $this->forceDelete($id);
        }
    }
}
