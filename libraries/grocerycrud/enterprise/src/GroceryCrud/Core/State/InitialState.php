<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Model;

class InitialState extends StateAbstract implements StateInterface
{

    public function getCachedData()
    {
        $render = new RenderAbstract();

        $cache = $this->gCrud->getCache();

        $output = $cache->getItem($this->getUniqueId() . '+data');

        $render->output = $output;
        $render->outputAsObject = json_decode($output);
        $render->isJSONResponse = true;

        return $render;
    }

    public function render()
    {
        $this->setInitialData();

        $output = $this->showInitData();

        $render = new RenderAbstract();

        $render->output = json_encode($output);
        $render->outputAsObject = $output;
        $render->isJSONResponse = true;

        return $render;
    }
    
    public function showInitData()
    {
        $data = (object)[];
        $config = $this->gCrud->getConfig();

        $data->i18n = $this->_getI18n();
        $data->subject = (object) [
            'subject_single' => $this->gCrud->getSubject() !== null ? $this->gCrud->getSubject() : '',
            'subject_plural' => $this->gCrud->getSubjectPlural() !== null ? $this->gCrud->getSubjectPlural() : ''
        ];

        $actionButtons = $this->gCrud->getActionButtons();

        $operations = (object) array(
            'add' => $this->gCrud->getLoadAdd(),
            'edit' => $this->gCrud->getLoadEdit(),
            'read' => $this->gCrud->getLoadRead(),
            'deleteSingle' => $this->gCrud->getLoadDelete(),
            'deleteMultiple' => $this->gCrud->getLoadDeleteMultiple(),
            'exportData' => $this->gCrud->getLoadExport(),
            'print' => $this->gCrud->getLoadPrint(),
            'actionButtons' => !empty($actionButtons)
        );

        $data->columns = $this->transformFieldsList($this->gCrud->getColumns(), $this->gCrud->getUnsetColumns());
        $data->add_fields = $this->transformFieldsList($this->gCrud->getAddFields(), $this->gCrud->getUnsetAddFields());
        $data->edit_fields = $this->getEditFields();
        $data->read_fields = $this->transformFieldsList($this->gCrud->getReadFields(), $this->gCrud->getUnsetReadFields());

        $data->paging = (object)[
            'defaultPerPage' => $config['default_per_page'],
            'pagingOptions'  => $config['paging_options']
        ];
        $data->primaryKeyField = $this->getPrimaryKeyField();
        $data->fieldTypes = $this->filterTypesPrivateInfo($this->getFieldTypes());
        $data->operations = $operations;

        return $data;
    }

    public function filterTypesPrivateInfo($fieldTypes) {
        foreach ($fieldTypes as &$fieldType) {
            if ($fieldType->dataType === 'upload') {
                unset($fieldType->options->uploadPath);
            }
        }

        return $fieldTypes;
    }

    public function getPrimaryKeyField() {
        $cachedString = $this->getUniqueCacheName(self::WITH_TABLE_NAME) . '+primaryKeyField';
        if ($this->config['backend_cache'] && $this->isInCache($cachedString)) {
            return $this->getCacheItem($cachedString);
        }

        $primaryKey = $this->gCrud->getModel()->getPrimaryKeyField();

        if ($this->config['backend_cache']) {
            $this->gCrud->getCache()->setItem($cachedString, $primaryKey);
        }

        return $primaryKey;
    }

    public function _getI18n()
    {
        $config = $this->gCrud->getConfig();

        $language = $this->gCrud->getLanguage() !== null ? $this->gCrud->getLanguage() : $config['default_language'];

        $languagePath = __DIR__ . '/../../i18n/' . $language . '.php';

        if (file_exists($languagePath)) {
            // Good old fashion way :)
            $i18nArray = include($languagePath);
            $i18n = (object)$i18nArray;
        } else {
            throw new Exception('Language path for language: "' . $language . '" does not exist');
        }

        foreach ($this->gCrud->getLandStrings() as $name => $string) {
            $i18n->$name = $string;
        }

        if ($this->gCrud->getSubject() !== null) {
            $i18n->subject = $this->gCrud->getSubject();
        }

        if ($this->gCrud->getSubjectPlural() !== null) {
            $i18n->subject_plural = $this->gCrud->getSubjectPlural();
        }

        return $i18n;
    }
}