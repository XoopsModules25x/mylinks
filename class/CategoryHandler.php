<?php

namespace XoopsModules\Mylinks;

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
 * @copyright ::  &copy; ZySpec Incorporated
 * @license   ::    {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @package   ::    mylinks
 * @subpackage:: class
 * @since     ::      File available since version 3.11
 * @author    ::     zyspec (owner@zyspec.com)
 */



$mylinksDir = \basename(\dirname(__DIR__));

/**
 * Class mylinksCategoryHandler_base
 */
class CategoryHandler extends \XoopsPersistableObjectHandler
{
    /**
     * @param \XoopsDatabase|null $db
     */
    public function mylinksCategoryHandler(\XoopsDatabase $db = null)
    {
        $this->__construct($db);
    }

    /**
     * mylinksCategoryHandler_base constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        $mylinksDir = \basename(\dirname(__DIR__));
        parent::__construct($db, 'mylinks_cat', Category::class, 'cid');
    }

    /**
     * Retrieve category names from Database
     * @param unknown $cats  - integer, returns single category name,
     *                       array returns array of category names
     *                       NULL return all category names
     * @return array   return category titles with category ID as key
     */
    public function getCatTitles($cats = null)
    {
        $catTitles = [];
        $criteria  = new \CriteriaCompo();
        if (isset($cats) && \is_array($cats)) {
            $catIdString = !empty($cats) ? '(' . \implode(',', $cats) . ')' : '';
            if ($catIdString) {
                $criteria->add(new \Criteria('cid', $catIdString, 'IN'));
            }
        } elseif (isset($cats) && ((int)$cats > 0)) {
            $criteria->add(new \Criteria('cid', (int)$cats, '='));
        }
        $catFields     = ['title'];
        $categoryArray = $this->getAll($criteria, $catFields, false);
        $catTitles     = [];
        if (\is_array($categoryArray) && \count($categoryArray)) {
            foreach ($categoryArray as $catItem) {
                $catTitles[$catItem['cid']] = $catItem['title'];
            }
        }

        return $catTitles;
    }
}

//eval('class ' . $mylinksDir . 'Category extends CategoryBase
//        {
//        }
//
//        class ' . $mylinksDir . 'CategoryHandler extends mylinksCategoryHandler_base
//        {
//        }
//    ');
