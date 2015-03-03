<?php

class MylinksPageNav
{
    var $total;
    var $perpage;
    var $current;
    var $url;

    function MylinksPageNav($total_items, $items_perpage, $current_start, $start_name="start", $extra_arg="")
    {
        $this->total   = intval($total_items);
        $this->perpage = intval($items_perpage);
        $this->current = intval($current_start);
        if ( $extra_arg != '' && ( substr($extra_arg, -5) != '&amp;' || substr($extra_arg, -1) != '&' ) ) {
            $extra_arg .= '&amp;';
        }
        $this->url = xoops_getenv('PHP_SELF') . '?' . $extra_arg . trim($start_name) . '=';
    }

    function renderNav($offset = 5)
    {
        $ret = '';
        if ( $this->total <= $this->perpage ) {
            return $ret;
        }
        $total_pages = ceil($this->total / $this->perpage);
        if ( $total_pages > 1 ) {
            $prev = $this->current - $this->perpage;
            if ( $prev >= 0 ) {
                $ret .= '<a href="' . $this->url . $prev . '"><u>&laquo;</u></a> ';
            }
            $counter = 1;
            $current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));
            while ( $counter <= $total_pages ) {
                if ( $counter == $current_page ) {
                    $ret .= '<strong>(' . $counter . ')</strong> ';
                } elseif ( ($counter > $current_page-$offset && $counter < $current_page + $offset ) || $counter == 1 || $counter == $total_pages ) {
                    if ( $counter == $total_pages && $current_page < $total_pages - $offset ) {
                        $ret .= '... ';
                    }
                    $ret .= '<a href="' . $this->url . (($counter - 1) * $this->perpage) . '">' . $counter . '</a> ';
                    if ( $counter == 1 && $current_page > 1 + $offset ) {
                        $ret .= '... ';
                    }
                }
                $counter++;
            }
            $next = $this->current + $this->perpage;
            if ( $this->total > $next ) {
                $ret .= '<a href="' . $this->url . $next . '"><u>&raquo;</u></a> ';
            }
        }

        return $ret;
    }

    function renderSelect($showbutton = false)
    {
        if ( $this->total < $this->perpage ) {
            return;
        }
        $total_pages = ceil($this->total / $this->perpage);
        $ret = '';
        if ( $total_pages > 1 ) {
            $ret = '<form name="pagenavform" action="' . xoops_getenv('PHP_SELF') . '">';
            $ret .= '<select name="pagenavselect" onchange="location=this.options[this.options.selectedIndex].value;">';
            $counter = 1;
            $current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));
            while ( $counter <= $total_pages ) {
                if ( $counter == $current_page ) {
                    $ret .= '<option value="' . $this->url . (($counter - 1) * $this->perpage) . '" selected="selected">' . $counter.'</option>';
                } else {
                    $ret .= '<option value="' . $this->url . (($counter - 1) * $this->perpage) . '">'.$counter . '</option>';
                }
                $counter++;
            }
            $ret .= '</select>';
            if ($showbutton) {
                $ret .= '&nbsp;<input type="submit" value="' . _GO . '" />';
            }
            $ret .= '</form>';
        }

        return $ret;
    }

    function renderImageNav($offset = 5)
    {
        if ( $this->total < $this->perpage ) {
            return;
        }
        $total_pages = ceil($this->total / $this->perpage);
        $ret = '';
        if ( $total_pages > 1 ) {
            $ret = '<table><tr>';
            $prev = $this->current - $this->perpage;
            if ( $prev >= 0 ) {
                $ret .= '<td class="pagneutral"><a href="'.$this->url.$prev.'">&lt;</a></td><td><img src="'.XOOPS_URL.'/images/blank.gif" width="6" alt="" /></td>';
            }
            $counter = 1;
            $current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));
            while ( $counter <= $total_pages ) {
                if ( $counter == $current_page ) {
                    $ret .= '<td class="pagact"><b>'.$counter.'</b></td>';
                } elseif ( ($counter > $current_page-$offset && $counter < $current_page + $offset ) || $counter == 1 || $counter == $total_pages ) {
                    if ( $counter == $total_pages && $current_page < $total_pages - $offset ) {
                        $ret .= '<td class="paginact">...</td>';
                    }
                    $ret .= '<td class="paginact"><a href="'.$this->url.(($counter - 1) * $this->perpage).'">'.$counter.'</a></td>';
                    if ( $counter == 1 && $current_page > 1 + $offset ) {
                        $ret .= '<td class="paginact">...</td>';
                    }
                }
                $counter++;
            }
            $next = $this->current + $this->perpage;
            if ( $this->total > $next ) {
                $ret .= '<td><img src="'.XOOPS_URL.'/images/blank.gif" width="6" alt="" /></td><td class="pagneutral"><a href="'.$this->url.$next.'">&gt;</a></td>';
            }
            $ret .= '</tr></table>';
        }

        return $ret;
    }
}
