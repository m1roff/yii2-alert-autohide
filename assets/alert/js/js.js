'use strict';

/**
 * close timer on 'onclick'
 * @param obj
 */
function closeTimeout(obj)
{
    clearTimeout($(obj).attr('timer'));
}