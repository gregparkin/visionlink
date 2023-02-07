/**
 * @package    CCT
 * @file       cct.js
 * @author     Greg Parkin <parking@us.ibm.com>
 * @date       $Date:  $ GMT
 * @version    $Revision:  $
 *
 * $Log:  $
 *
 *
 * $Source:  $
 */

function confirmDelete()
{
  var msg = "Are you sure you want to delete?";

  if (confirm(msg) == true)
  {
    event.returnValue=true;  // Work around for IE6 and IE7 bug
    return true;
  }

  event.returnValue=false;   // Work around for IE6 and IE7 bug
  return false;
}

// Blinking Text
// Example:
// <body onload="Blink();">
// This <span class="blink">text</span> is blinking red.

var b_timer = null; // blink timer
var b_on = true;    // blink state
var blnkrs = null;  // array of spans

function blink()
{
  var tmp = document.getElementsByTagName("span");

  if (tmp)
  {
    blnkrs = new Array();
    var b_count = 0;

    for (var i = 0; i < tmp.length; ++i)
    {
      if (tmp[i].className == "blink")
      {
        blnkrs[b_count] = tmp[i];
        ++b_count;
      }
    }

    // time in m.secs between blinks
    // 500 = 1/2 second
    blinkTimer(500);
  }
}

function blinkTimer(ival)
{
  if (b_timer)
  {
    window.clearTimeout(b_timer);
    b_timer = null;
  }

  blinkIt();
  b_timer = window.setTimeout('blinkTimer(' + ival + ')', ival);
}

function blinkIt()
{
  for (var i = 0; i < blnkrs.length; ++i)
  {
    if (b_on == true)
    {
      blnkrs[i].style.visibility = "hidden";
    }
    else
    {
      blnkrs[i].style.visibility = "visible";
    }
  }

  b_on =!b_on;
}

//
// Add onClick="self.close();" for links that need to close a window
//
function textCounter(field, countfield, maxlimit)
{
  if (field.value.length > maxlimit) // if too long...trim it!
    field.value = field.value.substring(0, maxlimit);
  else
    countfield.value = maxlimit - field.value.length;
}

//
// Used by the new menus
//
function go(page)
{
  document.f1.m1.selectedIndex = 0;
  document.f1.m2.selectedIndex = 0;
  document.f1.m3.selectedIndex = 0;
  document.f1.m4.selectedIndex = 0;
  if (page != '')
    self.location = page;
  return;
}

//
// Open new window
//
function NewWindow(page)
{
  window.open(page);
}

//
// Print this page
//
function PrintForm()
{
  window.print();
}

//
// Load this page
//
function GoThere(page)
{
  //   parent.location=page;
  self.location=page;
}

//
// Go back to previous page (History)
//
function goHist(a)
{
  history.go(a);    // Go back one.
}

//
// Open this page with these window options
//
function Start(page)
{
  OpenWin = this.open(page, "CtrlWindow", "toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes");
}

//
// Auto maximize the window: onLoad=MaximizeWindow();
//
function MaximizeWindow()
{
  top.window.moveTo(0,0);

  if (document.all)
  {
    top.window.resizeTo(screen.availWidth,screen.availHeight);
  }
  else if (document.layers||document.getElementById)
  {
    if (top.window.outerHeight < screen.availHeight || top.window.outerWidth < screen.availWidth)
    {
      top.window.outerHeight = screen.availHeight;
      top.window.outerWidth = screen.availWidth;
    }
  }
}

function ErrorMessageBox(msg)
{
  alert(msg);
}

//
// Open window in the middle of the screen
// [a href="javascript:openWindow('./pagename.html','_winName',230,180, 'scrollbars=no,resizeable=no');"]
//
function openWindow(theURL,winName,winWidth,winHeight,otherFeatures)
{
  var x = 0;
  var y = 0;

  x = (screen.availWidth - 12 - winWidth) / 2;
  y = (screen.availHeight - 48 - winHeight) / 2;

  if (otherFeatures != "")
  {
    otherFeatures = "," + otherFeatures;
  }

  var features = "screenX=" + x + ",screenY=" + y + ",width=" + winWidth + ",height=" + winHeight+",top="+y+",left="+x+"'" + otherFeatures;
  var NewWindow = window.open(theURL,winName,features);

  NewWindow.focus();
}

//
// Print this frame window
//
function framePrint(what)
{
  parent[what].focus();
  parent[what].print();
}

//
// Close this window
//
function wclose()
{
  self.close();
}

//
// Close window and refresh this window
//
function wwclose(cgi_program)
{
  if (! opener.closed)
  {
    opener.document.f1.action = cgi_program;
    opener.document.f1.submit();
    self.close();
  }
}

//
// Submit form f1 using a link
//
function submitform()
{
  if(document.f1.onsubmit())
  {
    document.f1.submit();
  }
}

//
// <body onFocus="keep_child_on_html_top();">
//
child = null;

function keep_child_on_html_top()
{
  if (child != NULL)
  {
    if (child.closed)
      child = null;
    else
      child.focus();
  }
}

