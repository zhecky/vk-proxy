/**
 * User: zhecky
 * Date: 13.12.12
 * Time: 0:50
 */

/**
 * by: James Coglan
 * @param obj object to count
 */
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function microtime(get_as_float) {
    // Returns either a string or a float containing the current time in seconds and microseconds
    //
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/microtime    // +   original by: Paulo Freitas
    // *     example 1: timeStamp = microtime(true);
    // *     results 1: timeStamp > 1000000000 && timeStamp < 2000000000
    var now = new Date().getTime() / 1000;
    var s = parseInt(now, 10);
    return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
}

function remove(elem) {
    elem.parentNode.removeChild(elem);
}

function escapeChars(str) {
    return str.replace(/>/g, "&gt;")
            .replace(/</g, "&lt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "`")
            .replace(/ {2,}/g, " ")
            .replace(/\n/g, "<br>")
            .trim();
}

function fromJSON(string) {
    var data = {};
    try {
        data = eval('(' + string + ')');
    } catch(e) {
        console.log(e);
        return false;
    }
    return data;
}

/**
 *
 * @param id
 * @return Element
 */
function ge(id) {
    return document.getElementById(id);
}

/**
 *
 * @param element Element
 * @param id string
 */
function searchById(element, id) {
    for (var key in element.childNodes) {
        var node = element.childNodes[key];
        if (node['id'] == id) {
            return node;
        }
        var result = searchById(node, id);
        if (result != null) {
            return result;
        }
    }
    return null;
}

/**
 *
 * @param id
 *
 * @return Element
 */
function ce(id) {
    return document.createElement(id);
}

function isNotEmpty(value) {
    if (typeof value !== 'undefined' && value != null) {
        if (typeof value === 'string') {
            return value != '';
        } if(typeof value === 'object'){
            return Object.size(value) > 0;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function isEmpty(value) {
    return !isNotEmpty(value);
}

function isDefined(value) {
    return (typeof value !== 'undefined');
}

function isFunction(value){
    return isDefined(value) && typeof(value) == "function";
}



function isArray(value) {
    return (isDefined(value['length']));
}

/**
 * create dom object from map.
 * Used keys: tag, className, src, html, value, selected, href, children, otherProperties
 * Events keys: onClick, onMouseDown, onMouseOver
 * @param map
 * @return Element
 */
function createDOM(map) {
    var result;
    if (isArray(map)) {
        result = [];
        for (var ind in map) {
            var mapElem = map[ind];
            var domElem = ce(mapElem['tag']);
            if (isDefined(mapElem['otherProperties'])){
                for(var propKey in mapElem['otherProperties']){
                    domElem.setAttribute(propKey, mapElem['otherProperties'][propKey]);
                }
            }
            if (isDefined(mapElem['id'])) {
                domElem.id = mapElem['id'];
            }
            if (isDefined(mapElem['className'])) {
                domElem.className = mapElem['className'];
            }
            if (isDefined(mapElem['src'])) {
                domElem.src = mapElem['src'];
            }
            if (isDefined(mapElem['html'])) {
                domElem.innerHTML = mapElem['html'];
            }
            if (isDefined(mapElem['value'])) {
                domElem.value = mapElem['value'];
            }
            if (isDefined(mapElem['selected'])) {
                domElem.selected = mapElem['selected'];
            }
            if (isDefined(mapElem['href'])) {
                domElem.href = mapElem['href'];
            }
            if (isDefined(mapElem['onClick'])) {
                domElem.onclick = mapElem['onClick'];
            }
            if (isDefined(mapElem['onMouseDown'])) {
                domElem.onmousedown = mapElem['onMouseDown'];
            }
            if (isDefined(mapElem['onMouseOver'])) {
                domElem.onmouseover = mapElem['onMouseOver'];
            }
            if (isDefined(mapElem['children'])) {
                if (isArray(mapElem['children'])) {
                    for (var i in mapElem['children']) {
                        domElem.appendChild(createDOM(mapElem['children'][i]));
                    }
                } else {
                    domElem.appendChild(createDOM(mapElem['children']));
                }
            }
            result.push(domElem);
        }
    } else {
        var mapElem = map;
        var domElem = ce(mapElem['tag']);
        if (isDefined(mapElem['otherProperties'])){
            for(var propKey in mapElem['otherProperties']){
                domElem.setAttribute(propKey, mapElem['otherProperties'][propKey]);
            }
        }
        if (isDefined(mapElem['id'])) {
            domElem.id = mapElem['id'];
        }
        if (isDefined(mapElem['className'])) {
            domElem.className = mapElem['className'];
        }
        if (isDefined(mapElem['src'])) {
            domElem.src = mapElem['src'];
        }
        if (isDefined(mapElem['html'])) {
            domElem.innerHTML = mapElem['html'];
        }
        if (isDefined(mapElem['value'])) {
            domElem.value = mapElem['value'];
        }
        if (isDefined(mapElem['selected'])) {
            domElem.selected = mapElem['selected'];
        }
        if (isDefined(mapElem['href'])) {
            domElem.href = mapElem['href'];
        }
        if (isDefined(mapElem['onClick'])) {
            domElem.onclick = mapElem['onClick'];
        }
        if (isDefined(mapElem['onMouseDown'])) {
            domElem.onmousedown = mapElem['onMouseDown'];
        }
        if (isDefined(mapElem['onMouseOver'])) {
            domElem.onmouseover = mapElem['onMouseOver'];
        }
        if (isDefined(mapElem['children'])) {
            if (isArray(mapElem['children'])) {
                for (var i in mapElem['children']) {
                    domElem.appendChild(createDOM(mapElem['children'][i]));
                }
            } else {
                domElem.appendChild(createDOM(mapElem['children']));
            }
        }
        result = domElem;
    }
    return result;
}


function fillSelectElement(element_id, data_list, selected_id, must_have_selected, disabled) {
    var destElem = ge(element_id);
    destElem.innerHTML = '';
    destElem.disabled = disabled;
    if (!must_have_selected) {
        destElem.appendChild(createDOM({tag : 'option', value : 0, html : 'not selected', selected : 0 == selected_id}));
    }
    for (var ind in data_list) {
        var item = data_list[ind];
        destElem.appendChild(createDOM({
            tag : 'option', value : item['id'], html : item['name'], selected : item['id'] == selected_id
        }));
    }
}

function setSelectedAtSelect(element_id, selected_id) {
    var destinationElement = ge(element_id);
    var options = destinationElement.getElementsByTagName("option");
    for (var ind in options) {
        var option = options[ind];
        if (option['value'] == selected_id) {
            option.selected = true;
        }
    }
}

// test it carefully
function insertAfter(elem, refElem) {
    var parent = refElem.parentNode;
    var next = refElem.nextSibling;
    if (next) {
        return parent.insertBefore(elem, next);
    } else {
        return parent.appendChild(elem);
    }
}

function moveCaretToEnd(el) {
    if (typeof el.selectionStart == "number") {
        el.selectionStart = el.selectionEnd = el.value.length;
    } else if (typeof el.createTextRange != "undefined") {
        el.focus();
        var range = el.createTextRange();
        range.collapse(false);
        range.select();
    }
}
