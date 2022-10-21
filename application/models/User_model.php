<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    // cari user beserta role_id
    public function getUserWithRole()
    {
        $query = "SELECT user.id, user.username, user.name, user_role.role, user.email, user.alamat, user.no_telp FROM user JOIN user_role ON user.role_id = user_role.id ORDER BY user.id ASC";
        return $this->db->query($query)->result_array();
    }

    // cari total user berdasarkan role
    public function countUserRole()
    {
        $query = "SELECT COUNT(user.username) AS total_user, user_role.role FROM user JOIN user_role ON user.role_id = user_role.id GROUP BY user_role.role ORDER BY user_role.id ASC ";
        return $this->db->query($query)->result_array();
    }
}
