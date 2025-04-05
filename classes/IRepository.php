<?php

interface IRepositiry{
    function findAll();
    function findById($id);
    function create($params);
    function delete($id);
}