function mltoggleEffect(targeturl, resizetarget, toggleimg) {
    var mlelestyle = xoopsGetElementById(resizetarget).style;
    var mlimgele = xoopsGetElementById(toggleimg);

    if (mlelestyle.display == "block") {
        mlelestyle.display = "none";
        mlimgele.src = targeturl + '/restore.gif';
        mlimgele.alt = 'Click me if you want to restore this block';
        mlimgele.title = 'Click me if you want to restore this block';
    }
    else {
        mlelestyle.display = "block";
        mlimgele.src = targeturl + '/minimize.gif';
        mlimgele.alt = 'Click me if you want to minimize this block';
        mlimgele.title = 'Click me if you want to minimize this block';
    }
}
