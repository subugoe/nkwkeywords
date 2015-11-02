<?php
namespace Subugoe\Nkwkeywords\ViewHelpers;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>
 *      Goettingen State Library
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper for sorting a bunch of pages by title
 */
class SortByPageTitleViewHelper extends AbstractViewHelper
{

    /**
     * @param \TYPO3\CMS\Frontend\Category\Collection\CategoryCollection $pages
     */
    public function render($pages)
    {

        $pages = $pages->getItems();

        // only show non-sysfolders
        $pages = array_filter($pages, [$this, 'getPages']);

        uasort($pages, [$this, 'sortByTitle']);

        $this->templateVariableContainer->add('pages', $pages);
    }

    /**
     * @param array $a
     * @param array $b
     * @return int
     */
    protected function sortByTitle($a, $b)
    {
        return ($a['title'] < $b['title']) ? -1 : 1;
    }

    /**
     * filter sys-folders from pages array
     *
     * @param array $page
     * @return bool
     */
    protected function getPages($page)
    {
        return ($page['doktype'] != 254);
    }
}
