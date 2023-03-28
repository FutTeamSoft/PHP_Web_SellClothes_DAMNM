<?php
class DB
{
    protected $conn;
    function __construct()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Không thể kết nối tới database!');
        mysqli_set_charset($conn, "utf8");
        $this->conn = $conn;
    }
    public function getConnection()
    {
        return $this->conn;
    }
    function __destruct()
    {
        mysqli_close($this->conn);
    }
    public function Offset($page = 1, $limit = DATA_PER_PAGE)
    {
        $limit = mysqli_escape_string($this->conn, $limit);
        if ($limit == 0) return '';
        $page = mysqli_escape_string($this->conn, $page);
        if ($page < 1 || !is_numeric($page)) $page = 1;
        $offset = ' LIMIT ' . (($page - 1) *  $limit) . ',' .  $limit;
        return $offset;
    }
}
class Admin
{
    public function login($password)
    {
        if (strtolower($password) == strtolower(ADMIN_PASSWORD)) return true;
        else return false;
    }
    public function startSession()
    {
        $_SESSION['admin'] = true;
    }
    public static function endSession()
    {
        unset($_SESSION['admin']);
    }
}
class User extends DB
{
    public function getCount()
    {
        $total = mysqli_query($this->conn, "SELECT COUNT(user_id) AS total FROM user");
        $total = mysqli_fetch_assoc($total)['total'];
        return $total;
    }
    // $this->conn = $conn;
    public function validUser($username)
    {
        $username = mysqli_escape_string($this->conn, $username);
        $a = mysqli_query($this->conn, "SELECT * FROM user WHERE `user_email` = '$username'");
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a))
                $b = $row;
        else $b = false;
        mysqli_free_result($a);
        return $b;
    }
    public function encryptedPassword($password)
    {
        return md5($password);
    }
    public function login($email, $password)
    {
        $email = mysqli_escape_string($this->conn, $email);
        $pass = $this->encryptedPassword($password);
        $a = mysqli_query($this->conn, "SELECT * FROM user WHERE `user_email` = '$email' AND `user_password` = '$pass'");
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a))
                $b = $row;
        else $b = false;
        mysqli_free_result($a);
        return $b;
    }
    public function register($user_fullname, $user_email, $user_address, $user_phone_number, $user_password)
    {
        $user_fullname = mysqli_escape_string($this->conn, $user_fullname);
        $a = $this->validUser($user_email);
        if ($a == false) {
            $user_password = $this->encryptedPassword($user_password);
            $b = mysqli_query($this->conn, "INSERT INTO user (`user_full_name`, `user_email`,`user_address`,`user_phone_number`, `user_password`) 
                                                        VALUES ('$user_fullname', '$user_email','$user_address','$user_phone_number', '$user_password')");
            if ($b)
                return true;
            else
                return false;
        } else return false;
    }
    public function getUser($user_id)
    {
        $user_id = mysqli_escape_string($this->conn, $user_id);
        $a = mysqli_query($this->conn, "SELECT * FROM user WHERE `user_id`='$user_id'");
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a))
                $b = $row;
        else $b = false;
        mysqli_free_result($a);
        return $b;
    }
    public function getUsers()
    {
        $a = mysqli_query($this->conn, "SELECT * FROM user");
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a))
                $b = array_merge($b, array($row));
        return $b;
    }
    public function updateUser($user_id, $user_fullname, $user_email, $user_phone_number, $user_address)
    {
        $a = $this->getUser($user_id);
        if ($a != false) {
            $user_id = mysqli_escape_string($this->conn, $user_id);
            $user_fullname = mysqli_escape_string($this->conn, $user_fullname);
            $user_email = mysqli_escape_string($this->conn, $user_email);
            $user_phone_number = mysqli_escape_string($this->conn, $user_phone_number);
            $user_address = mysqli_escape_string($this->conn, $user_address);
            $b = mysqli_query($this->conn, "UPDATE user SET `user_full_name` = '$user_fullname', `user_email` = '$user_email', `user_phone_number` = '$user_phone_number', `user_address` = '$user_address' WHERE user_id = $user_id");
            if ($b) return true;
            else return false;
        } else return false;
    }
    public function changePassword($user_id, $user_password)
    {
        $a = $this->getUser($user_id);
        if ($a != false) {
            $user_id = mysqli_escape_string($this->conn, $user_id);
            $user_password = $this->encryptedPassword($user_password);
            $b = mysqli_query($this->conn, "UPDATE user SET `user_password` = '$user_password' WHERE user_id = $user_id");
            if ($b) return true;
            else return false;
        } else return false;
    }
    public function startSession($user)
    {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_full_name'] = $user['user_full_name'];
        $_SESSION['user_email'] = $user['user_email'];
        return true;
    }
    public function updateSession($user_fullname = '', $user_email = '')
    {
        if ($user_fullname != '') $_SESSION['user_full_name'] = $user_fullname;
        if ($user_email != '') $_SESSION['user_email'] = $user_email;
        return true;
    }
    public static function endSession()
    {
        // session_destroy();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_full_name']);
        unset($_SESSION['user_email']);
    }
}
class ProductTypes extends DB
{
    public function getProductTypes()
    {
        $a = mysqli_query($this->conn, "SELECT PT.product_type_id, product_type_name, COUNT(PT.product_type_id) AS product_type_quantity FROM product_type PT LEFT JOIN products P ON PT.product_type_id = P.product_type_id GROUP BY PT.product_type_id");
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
        mysqli_free_result($a);
        return $b;
    }
}
class Products extends DB
{
    private $productWithProductType = 'SELECT P.*, PT.product_type_name FROM products P LEFT JOIN product_type PT ON P.product_type_id = PT.product_type_id';
    private function orderBy($order_by)
    {
        $order_by = mysqli_escape_string($this->conn, $order_by);
        switch ($order_by) {
            case 1:
                return 'product_id DESC';
                break;
            case 2:
                return 'product_rental_price ASC';
                break;
            case 3:
                return 'product_rental_price DESC';
                break;
            default:
                return 'product_id DESC';
                break;
        }
    }
    public function getCount()
    {
        $total = mysqli_query($this->conn, "SELECT COUNT(product_id) AS total FROM products");
        $total = mysqli_fetch_assoc($total)['total'];
        return $total;
    }
    public function validProduct($product_id)
    {
        $product_id = mysqli_escape_string($this->conn, $product_id);
        $a = mysqli_query($this->conn,  "SELECT product_id WHERE `product_id` = '$product_id'");
        if (mysqli_num_rows($a)) $b = true;
        else $b = false;
        mysqli_free_result($a);
        return $b;
    }
    public function getProducts($order_by = 1, $page = 1, $limit = DATA_PER_PAGE)
    {
        $order_by = $this->orderBy($order_by);
        $offset = $this->Offset($page, $limit);
        $a = mysqli_query($this->conn, $this->productWithProductType . ' ORDER BY ' . $order_by . ' ' . $offset);
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
        mysqli_free_result($a);
        return $b;
    }
    public function getProductById($product_id)
    {
        $product_id = mysqli_escape_string($this->conn, $product_id);
        $a = mysqli_query($this->conn, $this->productWithProductType . " WHERE `product_id` = '$product_id'");
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = $row;
        else $b = false;
        mysqli_free_result($a);
        return $b;
    }
    public function getProductsByProductTypeId($product_type_id, $order_by = 1, $page = 1, $limit = DATA_PER_PAGE)
    {
        $product_type_id = mysqli_escape_string($this->conn, $product_type_id);
        $order_by = $this->orderBy($order_by);
        $offset = $this->Offset($page, $limit);
        $a = mysqli_query($this->conn,  $this->productWithProductType . " WHERE P.product_type_id = '$product_type_id' ORDER BY $order_by " . $offset);
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
        mysqli_free_result($a);
        return $b;
    }

    public function getCountProductsByProductTypeId($product_type_id)
    {
        $product_type_id = mysqli_escape_string($this->conn, $product_type_id);
        $total = mysqli_query($this->conn, "SELECT COUNT(product_id) AS total FROM products WHERE product_type_id = '$product_type_id'");
        $total = mysqli_fetch_assoc($total)['total'];
        return $total;
    }
    public function postProduct($product_name, $product_introduce, $product_detail, $product_price, $product_img, $product_quantity, $product_location, $product_material, $product_type_id, $product_size)
    {
        $product_name = mysqli_escape_string($this->conn, $product_name);
        $product_introduce = mysqli_escape_string($this->conn, $product_introduce);
        $product_detail = mysqli_escape_string($this->conn, $product_detail);
        $product_price = mysqli_escape_string($this->conn, $product_price);
        $product_img = mysqli_escape_string($this->conn, $product_img);
        $product_quantity = mysqli_escape_string($this->conn, $product_quantity);
        $product_location = mysqli_escape_string($this->conn, $product_location);
        $product_material = mysqli_escape_string($this->conn, $product_material);
        $product_type_id = mysqli_escape_string($this->conn, $product_type_id);
        $product_size = mysqli_escape_string($this->conn, $product_size);

        $b = mysqli_query($this->conn, "INSERT INTO products (`product_name`, `product_introduce`, `product_detail`, `product_price`, `product_img`, `product_quantity`, `product_location`, `product_material`, `product_type_id`, `product_size`) 
													VALUES ('$product_name', '$product_introduce', '$product_detail', '$product_price', '$product_img', '$product_quantity', '$product_location', '$product_material', '$product_type_id', '$product_size')");
        // var_dump(mysqli_error($this->conn));
        if ($b) return true;
        else return false;
    }
    public function updateProduct($product_id, $product_name, $product_introduce, $product_detail, $product_price, $product_img, $product_quantity, $product_location, $product_material, $product_type_id, $product_size)
    {
        $a = $this->getProductById($product_id);
        if ($a != false) {
            $product_id = mysqli_escape_string($this->conn, $product_id);
            $product_name = mysqli_escape_string($this->conn, $product_name);
            $product_introduce = mysqli_escape_string($this->conn, $product_introduce);
            $product_detail = mysqli_escape_string($this->conn, $product_detail);
            $product_price = mysqli_escape_string($this->conn, $product_price);
            $product_img = mysqli_escape_string($this->conn, $product_img);
            $product_quantity = mysqli_escape_string($this->conn, $product_quantity);
            $product_location = mysqli_escape_string($this->conn, $product_location);
            $product_material = mysqli_escape_string($this->conn, $product_material);
            $product_type_id = mysqli_escape_string($this->conn, $product_type_id);
            $product_size = mysqli_escape_string($this->conn, $product_size);

            $b = mysqli_query($this->conn, "UPDATE products SET `product_name` = '$product_name', `product_introduce` = '$product_introduce', `product_detail` = '$product_detail', `product_price` = '$product_price', `product_img` = '$product_img',
				`product_quantity` = '$product_quantity', `product_location` = '$product_location', `product_material` = '$product_material', `product_type_id` = '$product_type_id', `product_size` = '$product_size' WHERE product_id = $product_id");
            if ($b) return true;
            else return false;
        } else return false;
    }
    public function search($keyword, $order_by = 1, $page = 1, $limit = DATA_PER_PAGE)
    {
        $keyword = mysqli_escape_string($this->conn, $keyword);
        $order_by = $this->orderBy($order_by);
        $offset = $this->Offset($page, $limit);
        $a = mysqli_query($this->conn, $this->productWithProductType . " WHERE MATCH(product_name) AGAINST ('$keyword') OR product_name LIKE ('%$keyword%') ORDER BY $order_by " . $offset);
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
        else $b = false;
        mysqli_free_result($a);
        return $b;
    }
    public function getCountSearch($keyword)
    {
        $keyword = mysqli_escape_string($this->conn, $keyword);
        $total = mysqli_query($this->conn, "SELECT COUNT(product_id) AS total FROM products WHERE MATCH(product_name) AGAINST ('$keyword')");
        $total = mysqli_fetch_assoc($total)['total'];
        return $total;
    }
}
class Product extends Products
{
}
class Cart extends DB
{
    public function getCount($user_id)
    {
        $user_id = mysqli_escape_string($this->conn, $user_id);
        $total = mysqli_query($this->conn, "SELECT COUNT(user_id) AS total FROM cart WHERE `user_id` = $user_id");
        $total = mysqli_fetch_assoc($total)['total'];
        return $total;
    }
    public function getCart($user_id)
    {
        $user_id = mysqli_escape_string($this->conn, $user_id);
        $a = mysqli_query($this->conn, "SELECT C.*, P.product_name, P.product_price, P.product_img, P.product_quantity FROM cart C LEFT JOIN products P ON C.product_id = P.product_id WHERE `user_id` = '$user_id'");
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
        mysqli_free_result($a);
        return $b;
    }
    public function postCart($user_id, $product_id, $cart_product_size, $cart_product_quantity)
    {
        $user_id = mysqli_escape_string($this->conn, $user_id);
        $product_id = mysqli_escape_string($this->conn, $product_id);
        $cart_product_size = mysqli_escape_string($this->conn, $cart_product_size);
        $cart_product_quantity = mysqli_escape_string($this->conn, $cart_product_quantity);
        $b = mysqli_query($this->conn, "INSERT INTO cart VALUES ('$user_id', '$product_id', '$cart_product_size', '$cart_product_quantity') ON DUPLICATE KEY UPDATE cart_product_quantity = cart_product_quantity + $cart_product_quantity");
        if ($b) return true;
        else return false;
    }
    public function updateCart($user_id, $product_id, $cart_product_size, $cart_product_quantity)
    {
        $user_id = mysqli_escape_string($this->conn, $user_id);
        $product_id = mysqli_escape_string($this->conn, $product_id);
        $cart_product_size = mysqli_escape_string($this->conn, $cart_product_size);
        $cart_product_quantity = mysqli_escape_string($this->conn, $cart_product_quantity);
        $b = mysqli_query($this->conn, "UPDATE cart SET `cart_product_quantity` = '$cart_product_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id' AND cart_product_size = '$cart_product_size'");
        if ($b) return true;
        else return false;
    }
    public function deleteCart($user_id, $product_id, $cart_product_size)
    {
        $user_id = mysqli_escape_string($this->conn, $user_id);
        $product_id = mysqli_escape_string($this->conn, $product_id);
        $cart_product_size = mysqli_escape_string($this->conn, $cart_product_size);
        $b = mysqli_query($this->conn, "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id AND cart_product_size = '$cart_product_size'");
        if ($b) return true;
        else return false;
    }
    public function deleteCartsByUserId($user_id)
    {
        $user_id = mysqli_escape_string($this->conn, $user_id);
        $b = mysqli_query($this->conn, "DELETE FROM cart WHERE user_id = $user_id");
        if ($b) return true;
        else return false;
    }
}
class Invoice extends DB
{
    public function getCount()
    {
        $total = mysqli_query($this->conn, "SELECT COUNT(invoice_id) AS total FROM invoice");
        $total = mysqli_fetch_assoc($total)['total'];
        return $total;
    }
    public function getInvoices($page = 1, $limit = DATA_PER_PAGE)
    {
        $offset = $this->Offset($page, $limit);
        $a = mysqli_query($this->conn, "SELECT * FROM invoice I LEFT JOIN user U ON I.user_id = U.user_id LEFT JOIN invoice_status INVS ON I.invoice_status_id = INVS.invoice_status_id ORDER BY invoice_id DESC " . $offset);
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
        mysqli_free_result($a);
        return $b;
    }
    public function getInvoice($invoice_id)
    {
        $invoice_id = mysqli_escape_string($this->conn, $invoice_id);
        $a = mysqli_query($this->conn, "SELECT * FROM invoice I LEFT JOIN user U ON I.user_id = U.user_id LEFT JOIN invoice_status INVS ON I.invoice_status_id = INVS.invoice_status_id WHERE `invoice_id` = '$invoice_id'");
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = $row;
        else $b = false;
        mysqli_free_result($a);
        return $b;
    }
    public function getInvoicesByUserId($user_id, $page = 1, $limit = DATA_PER_PAGE)
    {
        $user_id = mysqli_escape_string($this->conn, $user_id);
        $offset = $this->Offset($page, $limit);
        $a = mysqli_query($this->conn, "SELECT * FROM invoice I LEFT JOIN invoice_status INVS ON I.invoice_status_id = INVS.invoice_status_id WHERE user_id = '$user_id' ORDER BY invoice_id DESC " . $offset);
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
        mysqli_free_result($a);
        return $b;
    }
    public function getInvoiceDetails($invoice_id)
    {
        $invoice_id = mysqli_escape_string($this->conn, $invoice_id);
        $a = mysqli_query($this->conn, "SELECT invoice_id, ID.product_id, P.product_name, P.product_img, P.product_price, detail_product_size, detail_product_quantity FROM invoice_detail ID LEFT JOIN products P ON ID.product_id = P.product_id WHERE `invoice_id` = '$invoice_id'");
        $b = array();
        if (mysqli_num_rows($a))
            while ($row = mysqli_fetch_assoc($a)) $b = array_merge($b, array($row));
        mysqli_free_result($a);
        return $b;
    }
    public function postInvoice($user_id, $invoice_user_fullname, $invoice_user_phone_number, $invoice_user_email, $invoice_user_address)
    {
        $cart_subtotal = 0;
        $carts = new Cart;
        $cart = $carts->getCart($user_id);
        foreach ($cart as $k => $v) {
            $product_id = $v['product_id'];
            $cart_subtotal += $v['cart_product_quantity'] * $v['product_price'];
        }
        $user_id = mysqli_escape_string($this->conn, $user_id);

        $invoice_created_at = date("Y-m-d", time());
        $a = mysqli_query($this->conn, "INSERT INTO invoice (user_id, invoice_total_payment, invoice_created_at)
												VALUES ('$user_id', '$cart_subtotal', '$invoice_created_at')");
        if ($a) {
            $invoice_id = mysqli_insert_id($this->conn);
            foreach ($cart as $k => $v) {
                $product_id = $v['product_id'];
                $detail_product_size = $v['cart_product_size'];
                $detail_product_quantity  = $v['cart_product_quantity'];
                mysqli_query($this->conn, "INSERT INTO invoice_detail (invoice_id, product_id, detail_product_size, detail_product_quantity)
                                                                VALUES ('$invoice_id', '$product_id', '$detail_product_size', '$detail_product_quantity ')");
                // mysqli_query($this->conn, "UPDATE products SET product_quantity = CASE WHEN product_quantity-$invd_product_quantity < 0 THEN 0 ELSE product_quantity-$invd_product_quantity END WHERE product_id = $product_id");
            }
            $carts->deleteCartsByUserId($user_id);
            return true;
        } else return false;
    }
    public function updateStatus($invoice_id, $invoice_status_id)
    {
        $invoice_id = mysqli_escape_string($this->conn, $invoice_id);
        $invoice_status_id = mysqli_escape_string($this->conn, $invoice_status_id);
        mysqli_query($this->conn, "UPDATE invoice SET invoice_status_id = '$invoice_status_id' WHERE invoice_id = $invoice_id");
    }
}

class Statistic
{
    public function countProducts()
    {
        $a = new Products;
        return $a->getCount();
    }
    public function countInvoices()
    {
        $a = new Invoice();
        return $a->getCount();
    }
    public function countUsers()
    {
        $a = new User;
        return $a->getCount();
    }
}
