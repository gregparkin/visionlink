/**
 * Created by GREG on 7/2/2015.
 */

// ssmItems[...]=
// name,
// link,
// target,
// colspan,
// endrow?
//
// leave 'link' and 'target' blank to make a header
//
ssmItems = new Array();

ssmItems[0]  = ["PDR Menu",           "",    "", 4, "yes"];
ssmItems[1]  = ["PMTracker Home",     "xxx", "", 0, "no"];
ssmItems[2]  = ["Main Project Info",  "xxx", "", 0, "no"];
ssmItems[3]  = ["Additional Info",    "xxx", "", 0, "no"];
ssmItems[4]  = ["Milestone Dates",    "xxx", "", 0, "yes"];

ssmItems[5]  = ["Send PNL",           "",    "", 4, "yes"];
ssmItems[6]  = ["Project PNL",        "xxx", "", 0, "no"];
ssmItems[7]  = ["Discovery PNL",      "xxx", "", 0, "no"];
ssmItems[8]  = ["PNL History",        "xxx", "", 2, "yes"];

ssmItems[9]  = ["",           "",    "", 4, "yes"];
ssmItems[10] = ["Team List",          "xxx", "", 0, "no"];
ssmItems[11] = ["Scope/Requirements", "xxx", "", 3, "yes"];

ssmItems[12] = ["Asset Lists",           "",    "", 4, "yes"];
ssmItems[13] = ["Servers",                "xxx", "", 0, "no"];
ssmItems[14] = ["Multiple Server Update", "xxx", "", 0, "no"];
ssmItems[15] = ["Multiple SCOA/D Update", "xxx", "", 2, "yes"];



/*
ssmItems[0]  = ["Menu"]; //create header
ssmItems[1]  = ["Dynamic Drive", "http://www.dynamicdrive.com", ""];
ssmItems[2]  = ["What's New", "http://www.dynamicdrive.com/new.htm",""];
ssmItems[3]  = ["What's Hot", "http://www.dynamicdrive.com/hot.htm", ""];
ssmItems[4]  = ["Message Forum", "http://www.codingforums.com", "_new"];
ssmItems[5]  = ["Submit Script", "http://www.dynamicdrive.com/submitscript.htm", ""];
ssmItems[6]  = ["Link to Us", "http://www.dynamicdrive.com/link.htm", ""];

ssmItems[7]  = ["FAQ", "http://www.dynamicdrive.com/faqs.htm", "", 1, "no"]; //create two column row
ssmItems[8]  = ["Email", "http://www.dynamicdrive.com/contact.htm", "",1];

ssmItems[9]  = ["External Links", "", ""]; //create header
ssmItems[10] = ["JavaScript Kit", "http://www.javascriptkit.com", ""];
ssmItems[11] = ["Freewarejava", "http://www.freewarejava.com", ""];
ssmItems[12] = ["Coding Forums", "http://www.codingforums.com", ""];
*/

/*
 Configure menu styles below
 NOTE: To edit the link colors, go to the STYLE tags and edit the ssm2Items colors
 */
YOffset         = 150; // no quotes!!
XOffset         = 0;
staticYOffset   = 30; // no quotes!!
slideSpeed      = 20; // no quotes!!
waitTime        = 100; // no quotes!! this sets the time the menu stays out for after the mouse goes off it.
menuBGColor     = "black";
menuIsStatic    = "yes"; //this sets whether menu should stay static on the screen
menuWidth       = 600; // Must be a multiple of 10! no quotes!!
menuCols        = 2;
hdrFontFamily   = "verdana";
hdrFontSize     = "2";
hdrFontColor    = "white";
hdrBGColor      = "#170088";
hdrAlign        = "left";
hdrVAlign       = "center";
hdrHeight       = "15";
linkFontFamily  = "Verdana";
linkFontSize    = "2";
linkBGColor     = "white";
linkOverBGColor = "#FFFF99";
linkTarget      = "_top";
linkAlign       = "Left";
barBGColor      = "#444444";
barFontFamily   = "Verdana";
barFontSize     = "2";
barFontColor    = "white";
barVAlign       = "center";
barWidth        = 20; // no quotes!!
barText         = "MENU"; // <IMG> tag supported. Put exact html for an image to show.


//Static Slide Menu 6.5 © MaXimuS 2000-2001, All Rights Reserved.
//Site: http://www.absolutegb.com/maximus
//Script featured on Dynamic Drive (http://www.dynamicdrive.com)

//March 20th, 09'- Updated for IE8 compatibility

NS6 = (document.getElementById && !document.all);
IE  = (document.all);
NS  = (navigator.appName == "Netscape" && navigator.appVersion.charAt(0) == "4");

tempBar  = '';
barBuilt = 0;

function truebody()
{
    return(document.compatMode != "BackCompat") ? document.documentElement : document.body;
}

moving = setTimeout('null', 1);

function moveOut()
{
    if ((NS6 || NS) && parseInt(ssm.left) < 0 || IE && ssm.pixelLeft < 0)
    {
        clearTimeout(moving);
        moving = setTimeout('moveOut()', slideSpeed);
        slideMenu(10);
    }
    else
    {
        clearTimeout(moving);
        moving=setTimeout('null', 1);
    }
}

function moveBack()
{
    clearTimeout(moving);
    moving = setTimeout('moveBack1()', waitTime);
}

function moveBack1()
{
    if ((NS6 || NS) && parseInt(ssm.left) > (-menuWidth) || IE && ssm.pixelLeft > (-menuWidth))
    {
        clearTimeout(moving);
        moving = setTimeout('moveBack1()', slideSpeed);
        slideMenu(-10);
    }
    else
    {
        clearTimeout(moving);
        moving = setTimeout('null',1);
    }
}

function slideMenu(num)
{
    if (IE)
    {
        ssm.pixelLeft += num;
    }

    if (NS6)
    {
        ssm.left = parseInt(ssm.left) + num+"px";
    }

    if (NS)
    {
        ssm.left = parseInt(ssm.left) + num;
        bssm.clip.right += num;
        bssm2.clip.right += num;
    }
}

function makeStatic()
{
    if (NS || NS6)
    {
        winY = window.pageYOffset;
    }

    if (IE)
    {
        winY = truebody().scrollTop;
    }

    if (NS6 || IE || NS)
    {
        if (winY != lastY && winY > YOffset - staticYOffset)
        {
            smooth = .2 * (winY - lastY - YOffset + staticYOffset);
        }
        else if (YOffset - staticYOffset + lastY > YOffset - staticYOffset)
        {
            smooth = .2 * (winY - lastY - (YOffset - (YOffset - winY)));
        }
        else
        {
            smooth=0;
        }

        if(smooth > 0)
            smooth = Math.ceil(smooth);
        else
            smooth = Math.floor(smooth);

        if (IE)
            bssm.pixelTop += smooth;

        if (NS6)
            bssm.top = parseInt(bssm.top) + smooth + "px";

        if (NS)
            bssm.top = parseInt(bssm.top)+smooth;

        lastY = lastY + smooth;
        setTimeout('makeStatic()', 1)
    }
}

function buildBar()
{
    if (barText.indexOf('<IMG') > -1)
    {
        tempBar = barText;
    }
    else
    {
        for (b = 0; b < barText.length; b++)
        {
            tempBar += barText.charAt(b) + "<BR>";
        }
    }

    document.write('<td align="center" rowspan="100" width="' + barWidth + '" bgcolor="' + barBGColor + '" valign="' + barVAlign + '">');
    document.write('<p align="center"><font face="' + barFontFamily + '" Size="' + barFontSize + '" COLOR="' + barFontColor + '"><b>' + tempBar + '</b></font></p>');
    document.write('</td>');
}

function initSlide()
{
    if (NS6)
    {
        ssm = document.getElementById("thessm").style;
        bssm = document.getElementById("basessm").style;
        bssm.clip = "rect(0 " + document.getElementById("thessm").offsetWidth + " " + document.getElementById("thessm").offsetHeight + " 0)";
        ssm.visibility = "visible";
    }
    else if (IE)
    {
        ssm = document.all("thessm").style;
        bssm = document.all("basessm").style;
        bssm.visibility = "visible";
    }
    else if (NS)
    {
        bssm = document.layers["basessm1"];
        bssm2 = bssm.document.layers["basessm2"];
        ssm = bssm2.document.layers["thessm"];
        bssm2.clip.left=0;
        ssm.visibility = "show";
    }

    if (menuIsStatic=="yes")
        makeStatic();
}

function buildMenu()
{
    if (IE || NS6)
    {
        document.write('<div id="basessm" style="visibility: hidden; Position: Absolute;Left: ' + XOffset + 'px; Top: ' + YOffset + 'px; Z-Index: 20; width: ' + (menuWidth + barWidth + 10) + 'px">');
        document.write('<div id="thessm" style="Position: Absolute; Left: ' + (-menuWidth) + 'px; Top: 0; Z-Index: 20;" onmouseover="moveOut()" onmouseout="moveBack()">');
    }

    if (NS)
    {
        document.write('<layer name="basessm1" top="' + YOffset + '" LEFT=' + XOffset + ' visibility="show"><ilayer name="basessm2"><layer visibility="hide" name="thessm" bgcolor="' + menuBGColor + '" left="' + (-menuWidth) + '" onmouseover="moveOut()" onmouseout="moveBack()">');
    }

    if (NS6)
    {
        document.write('<table border="0" cellpadding="0" cellspacing="0" width="' + (menuWidth + barWidth + 2) + 'px" bgcolor="' + menuBGColor + '">');
        document.write('<tr>');
        document.write('<td>');
    }

    document.write('<table border="0" cellpadding="0" cellspacing="1" width="' + (menuWidth + barWidth + 2) + 'px" bgcolor="' + menuBGColor + '">');

    for(i = 0; i < ssmItems.length; i++)
    {
        if(!ssmItems[i][3])
        {
            ssmItems[i][3] = menuCols;
            ssmItems[i][5] = menuWidth - 1;
        }
        else if(ssmItems[i][3] != menuCols) 
        {
            ssmItems[i][5] = Math.round(menuWidth * (ssmItems[i][3] / menuCols) - 1);
        }
        
        if(ssmItems[i-1] && ssmItems[i-1][4] != "no")
        {
            document.write('<tr>');
        }

        if(!ssmItems[i][1])
        {
            document.write('<td bgcolor="' + hdrBGColor + '" HEIGHT="' + hdrHeight + 'px" ALIGN="' + hdrAlign + '" VALIGN="' + hdrVAlign + '" WIDTH="' + ssmItems[i][5] + '" COLSPAN="' + ssmItems[i][3] + '">');
            document.write('&nbsp;<font face="' + hdrFontFamily + '" Size="' + hdrFontSize + '" COLOR="' + hdrFontColor + '"><b>' + ssmItems[i][0] + '</b></font></td>');
        }
        else
        {
            if(!ssmItems[i][2])
                ssmItems[i][2] = linkTarget;

            document.write('<td ');
            document.write( 'bgcolor="' + linkBGColor + '" ');
            document.write( 'onmouseover="bgColor=\'' + linkOverBGColor + '\' "');
            document.write( 'onmouseout="bgColor=\'' + linkBGColor + '\' "');
            document.write( 'width="' + ssmItems[i][5] + 'px" ');
            document.write( 'colspan="' + ssmItems[i][3] + '">');
            document.write(     '<ilayer>');
            document.write(         '<div ');
            document.write(             'align="' + linkAlign + '">');
            document.write(             '<layer ');
            //document.write(                 'onmouseover="bgColor=\'' + linkOverBGColor + '\'" ');
            //document.write(                 'onmouseout="bgColor=\'' + linkBGColor + '\'" ');
            document.write(                 'width="100%" ');
            document.write(                 'align="' + linkAlign + '">');
            document.write(                     '<font ');
            document.write(                         'face="' + linkFontFamily + '" ');
            document.write(                         'size="' + linkFontSize + '">');
            document.write(                             '&nbsp;');
            document.write(                             '<a ');
            document.write(                                 'href="' + ssmItems[i][1] + '" ');
            document.write(                                 'target="' + ssmItems[i][2] + '" ');
            document.write(                                 'class="ssmItems">');
            document.write(                                     ssmItems[i][0]);
            document.write(                             '</a>');
            document.write(                     '</font>');
            document.write(             '</layer>');
            document.write(         '</div>');
            document.write(     '</ilayer>');
            document.write('</td>');
        }

        if(ssmItems[i][4] != "no" && barBuilt == 0)
        {
            buildBar();
            barBuilt = 1;
        }

        if(ssmItems[i][4] != "no")
        {
            document.write('</tr>');
        }
    }

    document.write('</table>');

    if (NS6)
    {
        document.write('</td>');
        document.write('</tr>');
        document.write('</table>');
    }

    if (IE || NS6)
    {
        document.write('</div>');
        document.write('</div>');
    }

    if (NS)
    {
        document.write('</layer>');
        document.write('</ilayer>');
        document.write('</layer>');
    }

    theleft =- menuWidth;
    lastY = 0;
    setTimeout('initSlide();', 1);
}

buildMenu();
