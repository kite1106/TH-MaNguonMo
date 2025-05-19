<?php
class CategoryModel
{
    private $db;
    private $Table_Name = 'category';

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function DanhSachTheLoai()
    {

        $query = "
                    SELECT c.*
                    FROM  " . $this->Table_Name . " c
                ";

        $stmt = $this->db->prepare($query); // KIÊM TRA 

        $stmt->execute(); //THỰC THI
        $result = $stmt->fetchAll(PDO::FETCH_OBJ); // LẤY RA CÁC ĐỐI TƯỢNG
        return $result;
    }

    public function ThemTheLoai($name, $des)
    {
        $query = "
                    INSERT INTO {$this->Table_Name} (name, description) VALUES (:name, :des);
        ";

        $stmt = $this->db->prepare($query);

        $name = htmlspecialchars(strip_tags($name)); // LỌC SCRIP
        $des = htmlspecialchars(strip_tags($des));

        $stmt->bindParam(':name', $name); // BẢO VỆ SQL INJECTION
        $stmt->bindParam(':des', $des);


        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
