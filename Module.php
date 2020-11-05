<?php

namespace mdm\admin;

use Yii;
use yii\helpers\Inflector;

/**
 * GUI manager for RBAC.
 *
 * Use [[\yii\base\Module::$controllerMap]] to change property of controller.
 * To change listed menu, use property [[$menus]].
 *
 * ```
 * 'layout' => 'left-menu', // default to null mean use application layout.
 * 'controllerMap' => [
 *     'assignment' => [
 *         'class' => 'mdm\admin\controllers\AssignmentController',
 *         'userClassName' => 'app\models\User',
 *         'idField' => 'id'
 *     ]
 * ],
 * 'menus' => [
 *     'assignment' => [
 *         'label' => 'Grand Access' // change label
 *     ],
 *     'route' => null, // disable menu
 * ],
 * ```
 *
 * @property string $mainLayout Main layout using for module. Default to layout of parent module.
 * Its used when `layout` set to 'left-menu', 'right-menu' or 'top-menu'.
 * @property array $menus List available menu of module.
 * It generated by module items .
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'assignment';
    /**
     * @var array Nav bar items.
     */
    public $navbar;
    /**
     * @var string Main layout using for module. Default to layout of parent module.
     * Its used when `layout` set to 'left-menu', 'right-menu' or 'top-menu'.
     */
    public $mainLayout = '@mdm/admin/views/layouts/main.php';
    /**
     * @var array
     * @see [[menus]]
     */
    private $_menus = [];
    /**
     * @var array
     * @see [[menus]]
     */
    private $_coreItems = [
        'user' => 'Users',
        'assignment' => 'Assignments'
    ];
    /**
     * @var array
     * @see [[items]]
     */
    private $_normalizeMenus;

    /**
     * @var string Default url for breadcrumb
     */
    public $defaultUrl;

    /**
     * @var string Default url label for breadcrumb
     */
    public $defaultUrlLabel;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin == 1)
            $this->_coreItems += array(
                'role' => 'Roles',
                'permission' => 'Permissions',
                'route' => 'Routes',
                'menu' => 'Menus',
                'modul' => 'Modul',
                'bagian' => 'Bagian',
                'user-act-history' => 'History User'
            );
        
        if (!isset(Yii::$app->i18n->translations['rbac-admin'])) {
            Yii::$app->i18n->translations['rbac-admin'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@mdm/admin/messages',
            ];
        }

        //user did not define the Navbar?
        if ($this->navbar === null && Yii::$app instanceof \yii\web\Application) {
            $this->navbar = [
                ['label' => Yii::t('rbac-admin', 'Help'), 'url' => ['default/index']],
                ['label' => Yii::t('rbac-admin', 'Ganti Password'), 'url' => ['/admin/user/change-password'], 'options' => ['data-method'=>'post']],
                [
                    'label' => 'Buku Panduan Manual', 
                    'url' => Yii::$app->request->baseUrl . "/buku-manual-admin.pdf", 
                    'linkOptions' => [
                        "target" => "_blank"
                    ]
                ],
                ['label' => Yii::t('rbac-admin', 'Logout'), 'url' => ['/site/logout'], 'options' => ['data-method'=>'post']],
            ];
        }
        if (class_exists('yii\jui\JuiAsset')) {
            Yii::$container->set('mdm\admin\AutocompleteAsset', 'yii\jui\JuiAsset');
        }
    }

    /**
     * Get available menu.
     * @return array
     */
    public function getMenus()
    {
        if ($this->_normalizeMenus === null) {
            $mid = '/' . $this->getUniqueId() . '/';
            // resolve core menus
            $this->_normalizeMenus = [];

            $config = components\Configs::instance();
            $conditions = [
                'user' => $config->db && $config->db->schema->getTableSchema($config->userTable),
                'assignment' => ($userClass = Yii::$app->getUser()->identityClass) && is_subclass_of($userClass, 'yii\db\BaseActiveRecord'),
                'menu' => $config->db && $config->db->schema->getTableSchema($config->menuTable),
            ];
            foreach ($this->_coreItems as $id => $lable) {
                if (!isset($conditions[$id]) || $conditions[$id]) {
                    $this->_normalizeMenus[$id] = ['label' => Yii::t('rbac-admin', $lable), 'url' => [$mid . $id]];
                }
            }
            foreach (array_keys($this->controllerMap) as $id) {
                $this->_normalizeMenus[$id] = ['label' => Yii::t('rbac-admin', Inflector::humanize($id)), 'url' => [$mid . $id]];
            }

            // user configure menus
            foreach ($this->_menus as $id => $value) {
                if (empty($value)) {
                    unset($this->_normalizeMenus[$id]);
                    continue;
                }
                if (is_string($value)) {
                    $value = ['label' => $value];
                }
                $this->_normalizeMenus[$id] = isset($this->_normalizeMenus[$id]) ? array_merge($this->_normalizeMenus[$id], $value)
                : $value;
                if (!isset($this->_normalizeMenus[$id]['url'])) {
                    $this->_normalizeMenus[$id]['url'] = [$mid . $id];
                }
            }
        }
        return $this->_normalizeMenus;
    }

    /**
     * Set or add available menu.
     * @param array $menus
     */
    public function setMenus($menus)
    {
        $this->_menus = array_merge($this->_menus, $menus);
        $this->_normalizeMenus = null;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            /* @var $action \yii\base\Action */
            $view = $action->controller->getView();

            $view->params['breadcrumbs'][] = [
                'label' => ($this->defaultUrlLabel ?: Yii::t('rbac-admin', 'Admin')),
                'url' => ['/' . ($this->defaultUrl ?: $this->uniqueId)],
            ];
            return true;
        }
        return false;
    }
}
