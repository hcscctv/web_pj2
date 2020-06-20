// 没用到的js

function getStyle(obj, st) {
    if (window.getComputedStyle) {
        return getComputedStyle(obj, null)[st];
    } else {
        return obj.currenStyle[st];
    }
}

function ani(obj, st, val, fun) {
    var W = getStyle(obj, st);
    var target = val;
    var x = 0;
    if (target > parseInt(W)) {
        var move = setInterval(function() {
            x++;
            if (x >= target - parseInt(W)) {
                clearInterval(move);
                obj.style[st] = target + 'px'
            }
            obj.style[st] = parseInt(W) + x + 'px'
        }, 30)
    } else {
        var move = setInterval(function() {
            x++;
            if (parseInt(W) - x <= target) {
                clearInterval(move);
                obj.style[st] = target + 'px'
            }
            obj.style[st] = parseInt(W) - x + 'px'
        }, 30)
    }
}


function alert() {
    alert("Imperfect system");
}