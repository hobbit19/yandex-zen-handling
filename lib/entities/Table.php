<?php

namespace lib\entities;

use lib\MysqlDriver;

abstract class Table
{
    private $_db;
    private $fields = '*';
    protected $name;
    private $joins = '';
    private $wheres = '1=1';
    private $order = '';
    private $groupby = '';
    private $showSql = false;

    public function __construct()
    {
        if (is_null($this->name))
            throw new \Exception("Не указана таблица!");

        $this->_db = MysqlDriver::getConnection();
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function setJoins($joins)
    {
        $this->joins = $joins;
    }

    public function setWheres($wheres)
    {
        $this->wheres = $wheres;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function setGroupBy($groupby)
    {
        $this->groupby = $groupby;
    }

    public function setShowSql($option)
    {
        $this->showSql = $option;
    }

    public function create($data)
    {
        $columns = $values = array();

        foreach ($data as $k => $v) {
            $columns[] = $k;
            $values[] = '\'' . $v . '\'';
        }

        $query = $this->_db->prepare('INSERT INTO ' . $this->name . ' (' . implode(',', $columns) . ') VALUES (' . implode(',', $values) . ')');
        $query->execute();

        return $this->_db->lastInsertId();
    }

    public function read()
    {
        $whereStr = '1=1';

        foreach ($this->wheres as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $where) {
                    $whereStr .= ' ' . (isset($where[3]) ? ' ' . $where[3] . ' ' : ' AND ') . $where[1] . ' ' . $where[0] . ' ' . $where[2];
                }
            } else {
                $whereStr .= ' ' . (isset($this->wheres[3]) ? ' ' . $this->wheres[3] . ' ' : ' AND ') . $this->wheres[1] . ' ' . $this->wheres[0] . ' ' . $this->wheres[2];
                break;
            }
        }


        $query = 'SELECT ' . $this->fields . ' FROM ' . $this->name . ' ' . $this->joins . ' WHERE ' . $whereStr . ' ' . $this->order . ' ' . $this->groupby;

        if ($this->showSql)
            echo $query;

        return $this->_db->query($query);
    }

    public function update($id, $data)
    {
        $columns = $values = array();

        foreach ($data as $k => $v) {
            $columns[] = $k . ' = \'' . $v . '\'';
        }

        $query = $this->_db->prepare('UPDATE ' . $this->name . ' SET ' . implode(', ', $columns) . ' WHERE id = ' . $id);

        $query->execute();

        return $this->_db->errorCode();
    }

    public function delete()
    {

    }
}