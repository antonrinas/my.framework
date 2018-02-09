<?php

namespace Api\Model;

use Main\Model\Base;

class Image extends Base
{
    protected $tableName = 'images';

    /**
     * @param int $id
     *
     * @return bool|void
     */
    public function delete($id)
    {
        $image = $this->find($id);
        if (!$image){
            return false;
        }

        $this->unlinkFile(PUBLIC_PATH . $image->getPath());
        $this->unlinkFile(PUBLIC_PATH . $image->getPathThumb1());
        $this->unlinkFile(PUBLIC_PATH . $image->getPathThumb2());
        $this->unlinkFile(PUBLIC_PATH . $image->getPathThumb3());
        $this->unlinkFile(PUBLIC_PATH . $image->getPathThumb4());
        $this->unlinkFile(PUBLIC_PATH . $image->getPathThumb5());

        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->tableName)->where($this->primaryKey, $id);
        $queryBuilderResult = $queryBuilder->compileQuery();
        $queryBuilder->reset();
        $this->getTableAdapter()->execute($queryBuilderResult['query'], $queryBuilderResult['params']);
    }

    /**
     * @param string $filePath
     */
    private function unlinkFile($filePath)
    {
        if (is_file($filePath)){
            unlink($filePath);
        }
    }
}