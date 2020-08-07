<?php

namespace XoopsModules\Mylinks;

/**
 * Class MylinksPageNav
 */
class PageNav
{
    public $total;
    public $perpage;
    public $current;
    public $url;

    /**
     * MylinksPageNav constructor.
     * @param        $total_items
     * @param        $items_perpage
     * @param        $current_start
     * @param string $start_name
     * @param string $extra_arg
     */
    public function __construct(
        $total_items,
        $items_perpage,
        $current_start,
        $start_name = 'start',
        $extra_arg = ''
    ) {
        $this->total   = (int)$total_items;
        $this->perpage = (int)$items_perpage;
        $this->current = (int)$current_start;
        if ('' != $extra_arg && ('&amp;' !== mb_substr($extra_arg, -5) || '&' !== mb_substr($extra_arg, -1))) {
            $extra_arg .= '&amp;';
        }
        $this->url = \xoops_getenv('SCRIPT_NAME') . '?' . $extra_arg . \trim($start_name) . '=';
    }

    /**
     * @param int $offset
     * @return string
     */
    public function renderNav($offset = 5)
    {
        $ret = '';
        if ($this->total <= $this->perpage) {
            return $ret;
        }
        $total_pages = \ceil($this->total / $this->perpage);
        if ($total_pages > 1) {
            $prev = $this->current - $this->perpage;
            if ($prev >= 0) {
                $ret .= '<a href="' . $this->url . $prev . '"><u>&laquo;</u></a> ';
            }
            $counter      = 1;
            $current_page = (int)\floor(($this->current + $this->perpage) / $this->perpage);
            while ($counter <= $total_pages) {
                if ($counter == $current_page) {
                    $ret .= '<strong>(' . $counter . ')</strong> ';
                } elseif (($counter > $current_page - $offset && $counter < $current_page + $offset) || 1 == $counter
                          || $counter == $total_pages) {
                    if ($counter == $total_pages && $current_page < $total_pages - $offset) {
                        $ret .= '... ';
                    }
                    $ret .= '<a href="' . $this->url . (($counter - 1) * $this->perpage) . '">' . $counter . '</a> ';
                    if (1 == $counter && $current_page > 1 + $offset) {
                        $ret .= '... ';
                    }
                }
                ++$counter;
            }
            $next = $this->current + $this->perpage;
            if ($this->total > $next) {
                $ret .= '<a href="' . $this->url . $next . '"><u>&raquo;</u></a> ';
            }
        }

        return $ret;
    }

    /**
     * @param bool $showbutton
     * @return string|void
     */
    public function renderSelect($showbutton = false)
    {
        if ($this->total < $this->perpage) {
            return;
        }
        $total_pages = \ceil($this->total / $this->perpage);
        $ret         = '';
        if ($total_pages > 1) {
            $ret          = '<form name="pagenavform" action="' . \xoops_getenv('SCRIPT_NAME') . '">';
            $ret          .= '<select name="pagenavselect" onchange="location=this.options[this.options.selectedIndex].value;">';
            $counter      = 1;
            $current_page = (int)\floor(($this->current + $this->perpage) / $this->perpage);
            while ($counter <= $total_pages) {
                if ($counter == $current_page) {
                    $ret .= '<option value="' . $this->url . (($counter - 1) * $this->perpage) . '" selected>' . $counter . '</option>';
                } else {
                    $ret .= '<option value="' . $this->url . (($counter - 1) * $this->perpage) . '">' . $counter . '</option>';
                }
                ++$counter;
            }
            $ret .= '</select>';
            if ($showbutton) {
                $ret .= '&nbsp;<input type="submit" value="' . _GO . '">';
            }
            $ret .= '</form>';
        }

        return $ret;
    }

    /**
     * @param int $offset
     * @return string|void
     */
    public function renderImageNav($offset = 5)
    {
        if ($this->total < $this->perpage) {
            return;
        }
        $total_pages = \ceil($this->total / $this->perpage);
        $ret         = '';
        if ($total_pages > 1) {
            $ret  = '<table><tr>';
            $prev = $this->current - $this->perpage;
            if ($prev >= 0) {
                $ret .= '<td class="pagneutral"><a href="' . $this->url . $prev . '">&lt;</a></td><td><img src="' . XOOPS_URL . '/images/blank.gif" width="6" alt=""></td>';
            }
            $counter      = 1;
            $current_page = (int)\floor(($this->current + $this->perpage) / $this->perpage);
            while ($counter <= $total_pages) {
                if ($counter == $current_page) {
                    $ret .= '<td class="pagact"><b>' . $counter . '</b></td>';
                } elseif (($counter > $current_page - $offset && $counter < $current_page + $offset) || 1 == $counter
                          || $counter == $total_pages) {
                    if ($counter == $total_pages && $current_page < $total_pages - $offset) {
                        $ret .= '<td class="paginact">...</td>';
                    }
                    $ret .= '<td class="paginact"><a href="' . $this->url . (($counter - 1) * $this->perpage) . '">' . $counter . '</a></td>';
                    if (1 == $counter && $current_page > 1 + $offset) {
                        $ret .= '<td class="paginact">...</td>';
                    }
                }
                ++$counter;
            }
            $next = $this->current + $this->perpage;
            if ($this->total > $next) {
                $ret .= '<td><img src="' . XOOPS_URL . '/images/blank.gif" width="6" alt=""></td><td class="pagneutral"><a href="' . $this->url . $next . '">></a></td>';
            }
            $ret .= '</tr></table>';
        }

        return $ret;
    }
}
