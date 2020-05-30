<?php

namespace common\interfaces;

interface IRepository 
{
    /**
     * Get
     * 
     * @return array|null
     */
    public static function getOne($id);

    /**
     * Delete
     * 
     * @param integer $id
     * @return bool
     */
    public static function delete($id);

    /**
     * List
     * 
     * @return array
     */
    public static function list($page_size);

    /**
     * Make model for forms
     * 
     * @return mixed
     */
    public static function makeModel();

    /**
     * Create
     * 
     * @param array $params
     * @return bool
     */
    public static function create($params);

    /**
     * Update
     * 
     * @param array $params
     * @return bool
     */
    public static function update($id, $params);

}