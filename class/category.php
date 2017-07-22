<?php
/**
 * MyLinks category.php
 *
 * Xoops mylinks - a multicategory links module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright ::  {@link https://xoops.org/ XOOPS Project}
 * @copyright ::  &copy; ZySpec Incorporated
 * @license   ::    {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package   ::    mylinks
 * @subpackage:: class
 * @author    ::     zyspec (owner@zyspec.com)
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

$moduleDirName = basename(dirname(__DIR__));

/**
 * Class MylinksCategory_base
 */
class MylinksCategory_base extends XoopsObject
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        //definitions of the table field names from the database
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('pid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, true, 50);
        $this->initVar('imgurl', XOBJ_DTYPE_TXTAREA);
    }

    /**
     * Returns category title using PHP5
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

    /**
     * Generates path from the root id to a given id($id)
     * @param  int    $id
     * @param  string $path
     * @return string
     */
    public function getPathFromId($id = null, $path = '')
    {
        $id   = isset($id) ? (int)$id : $this->cid;
        $myts = MyTextSanitizer::getInstance();
        $name = $myts->htmlSpecialChars($this->title);
        $path = "/{$name}{$path}";
        if ($this->pid != 0) {
            $path = $this->getPathFromId($this->pid, $path);
        }

        return $path;
    }
}

/**
 * Class MylinksCategoryHandler_base
 */
class MylinksCategoryHandler_base extends XoopsPersistableObjectHandler
{

    /**
     * mylinksCategoryHandler_base constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct($db)
    {
        $moduleDirName = basename(dirname(__DIR__));
        parent::__construct($db, 'mylinks_cat', strtolower($moduleDirName) . 'Category', 'cid');
    }

    /**
     *
     * Retrieve category names from Database
     * @param  unknown $cats - integer, returns single category name,
     *                       array returns array of category names
     *                       NULL return all category names
     * @return array   return category titles with category ID as key
     */
    public function getCatTitles($cats = null)
    {
        $catTitles = array();
        $criteria  = new CriteriaCompo();
        if (isset($cats) && is_array($cats)) {
            $catIdString = (!empty($cats)) ? '(' . implode(',', $cats) . ')' : '';
            if ($catIdString) {
                $criteria->add(new Criteria('cid', $catIdString, 'IN'));
            }
        } elseif (isset($cats) && ((int)$cats > 0)) {
            $criteria->add(new Criteria('cid', (int)$cats, '='));
        }
        $catFields = array('title');
        $catArray  =& $this->getAll($criteria, $catFields, false);
        $catTitles = array();
        if (is_array($catArray) && count($catArray)) {
            foreach ($catArray as $catItem) {
                $catTitles[$catItem['cid']] = $catItem['title'];
            }
        }

        return $catTitles;
    }
}

eval('class ' . $moduleDirName . 'Category extends MylinksCategory_base
        {
        }

        class ' . $moduleDirName . 'CategoryHandler extends MylinksCategoryHandler_base
        {
        }
    ');
