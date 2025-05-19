<?php

class ProductModel
{

    public $db;
    private $table_name = 'product';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function DanhSachSanPham()
    {
        $query =    "
                        SELECT p.*, c.name AS THELOAI
                        FROM " . $this->table_name . " p, category c
                        WHERE p.category_id = c.id
                    ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    

    public function LaySanPhamTheoID($id)
    {
        $query = "
                    SELECT p.*
                    FROM {$this->table_name} p
                    WHERE p.id =  {$id}";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }


    public function ThemSanPham($name, $price, $des, $categoryid, $hinhanh = null)
    {
        $error = [];
        if (empty($name)) {
            $error['name'] = "Chưa có tên sản phẩm";
        }
        if (empty($des)) {
            $error['des'] = "Chưa có mô tả sản phẩm";
        }
        if (is_numeric($price) == false || $price < 0) {
            $error['price'] = 'Giá sản phẩm ko phù hợp';
        }

        if (count($error) > 0) {
            return $error;
        }


        $query = "
                INSERT INTO {$this->table_name} (name,price,description,category_id,image) VALUES (:name,:price,:des,:categoryid, :hinhanh)
        ";

        $stmt = $this->db->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $des = htmlspecialchars(strip_tags($des));
        $price = htmlspecialchars(strip_tags($price));
        $categoryid = htmlspecialchars(strip_tags($categoryid));


        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':des', $des);
        $stmt->bindParam(':categoryid', $categoryid);
        $stmt->bindParam(':hinhanh', $hinhanh);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

public function ChinhSuaSanPham($id, $name, $price, $des, $categoryid, $hinhanh = null)
    {
        if ($hinhanh == null) {
            $query = "
                    UPDATE {$this->table_name}
                    SET name = :name, price = :price, description = :des, category_id = :categoryid
                    WHERE id = :id
        ";
            $stmt = $this->db->prepare($query);

            $name = htmlspecialchars(strip_tags($name));
            $id = htmlspecialchars(strip_tags($id));
            $price = htmlspecialchars(strip_tags($price));
            $des = htmlspecialchars(strip_tags($des));
            $categoryid = htmlspecialchars(strip_tags($categoryid));

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);$stmt->bindParam(':des', $des);
            $stmt->bindParam(':categoryid', $categoryid);


            if ($stmt->execute()) {
                return true;
            }
            return false;
        } else {
            $query = "
                    UPDATE {$this->table_name}
                    SET name = :name, price = :price, description = :des, category_id = :categoryid, image = :hinhanh
                    WHERE id = :id
                ";

            $stmt = $this->db->prepare($query);

            $name = htmlspecialchars(strip_tags($name));
            $id = htmlspecialchars(strip_tags($id));
            $price = htmlspecialchars(strip_tags($price));
            $des = htmlspecialchars(strip_tags($des));
            $categoryid = htmlspecialchars(strip_tags($categoryid));

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':des', $des);
            $stmt->bindParam(':categoryid', $categoryid);
            $stmt->bindParam(':hinhanh', $hinhanh);


            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
    }

    public function XoaSanPham($id)
    {
        $query = "
                    DELETE p
                    FROM {$this->table_name} p 
                    WHERE p.id = :id
        ";

        $stmt =  $this->db->prepare($query);

        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
