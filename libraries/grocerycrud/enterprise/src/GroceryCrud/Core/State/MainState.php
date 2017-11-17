<?php
namespace GroceryCrud\Core\State;

use GroceryCrud\Core\GroceryCrud as GCrud;
use GroceryCrud\Core\Render\RenderAbstract;
use GroceryCrud\Core\Model;


class MainState extends StateAbstract implements StateInterface
{
    /**
     * MainState constructor.
     * @param GCrud $gCrud
     */
    function __construct(GCrud $gCrud)
    {
        $this->gCrud = $gCrud;
    }

    public function render()
    {
        $layout = $this->gCrud->getLayout();

        $layout->setThemeBasics();

        $apiUrlPath = $this->gCrud->getApiUrlPath();
        if ($apiUrlPath !== null) {
            $layout->setApiUrl($apiUrlPath);
        }

        $uniqueId = $this->gCrud->getUniqueId();

        if ($uniqueId !== null) {
            $layout->setUniqueId($uniqueId);
        } else {
            $layout->setUniqueId(md5($layout->getApiUrl()));
        }

        $output = $this->showList();

        $render = new RenderAbstract();

        $render->output = $output;
        $render->js_files = $layout->get_js_files();
        $render->css_files = $layout->get_css_files();
        $render->isJSONResponse = false;

        return $render;

    }

    public function showList()
    {
        $data = $this->_getCommonData();

        $texteditorFields = $this->gCrud->getTextEditorFields();

        $data->load_jquery = $this->gCrud->getLoadJquery();
        $data->load_bootstrap = $this->gCrud->getLoadBootstrap();
        $data->load_jquery_ui = $this->gCrud->getLoadJqueryUi();
        $data->load_texteditor = !empty($texteditorFields);
        $data->load_modernizr = $this->gCrud->getLoadModernizr();
        $data->autoload_javascript = $this->gCrud->getAutoloadJavaScript();
        $data->config = $this->getConfigParameters();

        return $this->gCrud->getLayout()->theme_view('datagrid.php', $data, true);
    }

    public function _getCommonData()
    {
        $data = (object)array();

        $data->subject 				= $this->gCrud->getSubject();
        $data->subject_plural 		= $this->gCrud->getSubjectPlural();

        return $data;
    }
}