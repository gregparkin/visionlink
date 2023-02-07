/**
 * Created by gparkin on 8/6/16.
 */
!function(a) {
    a.jqx.jqxWidget("jqxGrid", "", {});
    a.extend(a.jqx._jqxGrid.prototype, {
        defineInstance: function() {
            var b = {
                disabled: false,
                width: 600,
                height: 400,
                pagerheight: 28,
                groupsheaderheight: 34,
                pagesize: 10,
                pagesizeoptions: [ "5", "10", "20" ],
                rowsheight: 25,
                columnsheight: 25,
                filterrowheight: 31,
                groupindentwidth: 30,
                rowdetails: false,
                enablerowdetailsindent: true,
                enablemousewheel: true,
                initrowdetails: null,
                layoutrowdetails: null,
                editable: false,
                editmode: "selectedcell",
                pageable: false,
                pagermode: "default",
                pagerbuttonscount: 5,
                groupable: false,
                sortable: false,
                filterable: false,
                filtermode: "default",
                autoshowfiltericon: true,
                showfiltercolumnbackground: true,
                showpinnedcolumnbackground: true,
                showsortcolumnbackground: true,
                altrows: false,
                altstart: 1,
                altstep: 1,
                showrowdetailscolumn: true,
                showtoolbar: false,
                toolbarheight: 34,
                showstatusbar: false,
                statusbarheight: 34,
                enableellipsis: true,
                groups: [],
                groupsrenderer: null,
                groupcolumnrenderer: null,
                groupsexpandedbydefault: false,
                pagerrenderer: null,
                touchmode: "auto",
                columns: [],
                selectedrowindex: -1,
                selectedrowindexes: new Array(),
                selectedcells: new Array(),
                autobind: true,
                selectedcell: null,
                tableZIndex: 799,
                headerZIndex: 299,
                updatefilterconditions: null,
                showaggregates: false,
                showfilterrow: false,
                autorowheight: false,
                autokoupdates: true,
                handlekeyboardnavigation: null,
                showsortmenuitems: true,
                showfiltermenuitems: true,
                showgroupmenuitems: true,
                enablebrowserselection: false,
                enablekeyboarddelete: true,
                clipboard: true,
                ready: null,
                updatefilterpanel: null,
                autogeneratecolumns: false,
                rowdetailstemplate: null,
                scrollfeedback: null,
                rendertoolbar: null,
                renderstatusbar: null,
                rendered: null,
                multipleselectionbegins: null,
                columngroups: null,
                cellhover: null,
                source: {
                    beforeprocessing: null,
                    beforesend: null,
                    loaderror: null,
                    localdata: null,
                    data: null,
                    datatype: "array",
                    datafields: [],
                    url: "",
                    root: "",
                    record: "",
                    id: "",
                    totalrecords: 0,
                    recordstartindex: 0,
                    recordendindex: 0,
                    loadallrecords: true,
                    sortcolumn: null,
                    sortdirection: null,
                    sort: null,
                    filter: null,
                    sortcomparer: null
                },
                dataview: null,
                updatedelay: null,
                autoheight: false,
                autowidth: false,
                showheader: true,
                showgroupsheader: true,
                closeablegroups: true,
                scrollbarsize: a.jqx.utilities.scrollBarSize,
                touchscrollbarsize: a.jqx.utilities.touchScrollBarSize,
                scrollbarautoshow: a.jqx.utilities.scrollBarAutoShow,
                virtualmode: false,
                sort: null,
                columnsmenu: true,
                columnsresize: false,
                columnsreorder: false,
                columnsmenuwidth: 15,
                autoshowcolumnsmenubutton: true,
                popupwidth: "auto",
                sorttogglestates: 2,
                rendergridrows: null,
                enableanimations: true,
                enabletooltips: false,
                selectionmode: "singlerow",
                enablehover: true,
                loadingerrormessage: "The data is still loading. When the data binding is completed, the Grid raises the 'bindingcomplete' event. Call this function in the 'bindingcomplete' event handler.",
                verticalscrollbarstep: 25,
                verticalscrollbarlargestep: 400,
                horizontalscrollbarstep: 10,
                horizontalscrollbarlargestep: 50,
                keyboardnavigation: true,
                touchModeStyle: "auto",
                autoshowloadelement: true,
                showdefaultloadelement: true,
                showemptyrow: true,
                autosavestate: false,
                autoloadstate: false,
                _updating: false,
                _pagescache: new Array(),
                _pageviews: new Array(),
                _cellscache: new Array(),
                _rowdetailscache: new Array(),
                _rowdetailselementscache: new Array(),
                _requiresupdate: false,
                _hasOpenedMenu: false,
                scrollmode: "physical",
                deferreddatafields: null,
                localization: null,
                rtl: false,
                menuitemsarray: [],
                events: [ "initialized", "rowClick", "rowSelect", "rowUnselect", "groupExpand", "groupCollapse", "sort", "columnClick", "cellClick", "pageChanged", "pageSizeChanged", "bindingComplete", "groupsChanged", "filter", "columnResized", "cellSelect", "cellUnselect", "cellBeginEdit", "cellEndEdit", "cellValueChanged", "rowExpand", "rowCollapse", "rowDoubleClick", "cellDoubleClick", "columnReordered", "pageChanging" ]
            };
            a.extend(true, this, b);
            return b;
        },
        createInstance: function(b) {
            this.that = this;
            this.pagesize = parseInt(this.pagesize);
            this.toolbarheight = parseInt(this.toolbarheight);
            this.columnsheight = parseInt(this.columnsheight);
            this.filterrowheight = parseInt(this.filterrowheight);
            this.statusbarheight = parseInt(this.statusbarheight);
            this.groupsheaderheight = parseInt(this.groupsheaderheight);
            var c = "<div class='jqx-clear jqx-border-reset jqx-overflow-hidden jqx-max-size jqx-position-relative'><div tabindex='1' class='jqx-clear jqx-max-size jqx-position-relative jqx-overflow-hidden jqx-background-reset' id='wrapper" + this.element.id + "'><div class='jqx-clear jqx-position-absolute' id='toolbar' style='visibility: hidden;'></div><div class='jqx-clear jqx-position-absolute' id='groupsheader' style='visibility: hidden;'></div><div class='jqx-clear jqx-overflow-hidden jqx-position-absolute jqx-border-reset jqx-background-reset' id='content" + this.element.id + "'></div><div class='jqx-clear jqx-position-absolute' id='verticalScrollBar" + this.element.id + "'></div><div class='jqx-clear jqx-position-absolute' id='horizontalScrollBar" + this.element.id + "'></div><div class='jqx-clear jqx-position-absolute jqx-border-reset' id='bottomRight'></div><div class='jqx-clear jqx-position-absolute' id='statusbar'></div><div class='jqx-clear jqx-position-absolute' id='pager' style='z-index: 20;'></div></div></div>";
            this.element.innerText = "";
            this.element.innerHTML = "";
            if (15 != a.jqx.utilities.scrollBarSize) this.scrollbarsize = a.jqx.utilities.scrollBarSize;
            if (this.source) {
                if (!this.source.dataBind) {
                    if (!a.jqx.dataAdapter) throw new Error("jqxGrid: Missing reference to jqxdata.js");
                    this.source = new a.jqx.dataAdapter(this.source);
                }
                var d = this.source._source.datafields;
                if (d && d.length > 0) {
                    this.editmode = this.editmode.toLowerCase();
                    this.selectionmode = this.selectionmode.toLowerCase();
                }
            }
            this.host.attr("role", "grid");
            this.host.attr("align", "left");
            this.element.innerHTML = c;
            this.host.addClass(this.toTP("jqx-grid"));
            this.host.addClass(this.toTP("jqx-reset"));
            this.host.addClass(this.toTP("jqx-rc-all"));
            this.host.addClass(this.toTP("jqx-widget"));
            this.host.addClass(this.toTP("jqx-widget-content"));
            this.wrapper = this.host.find("#wrapper" + this.element.id);
            this.content = this.host.find("#content" + this.element.id);
            this.content.addClass(this.toTP("jqx-reset"));
            var e = this.host.find("#verticalScrollBar" + this.element.id);
            var f = this.host.find("#horizontalScrollBar" + this.element.id);
            this.bottomRight = this.host.find("#bottomRight").addClass(this.toTP("jqx-grid-bottomright")).addClass(this.toTP("jqx-scrollbar-state-normal"));
            if (!e.jqxScrollBar) {
                throw new Error("jqxGrid: Missing reference to jqxscrollbar.js");
                return;
            }
            this.editors = new Array();
            this.vScrollBar = e.jqxScrollBar({
                vertical: true,
                rtl: this.rtl,
                touchMode: this.touchmode,
                step: this.verticalscrollbarstep,
                largestep: this.verticalscrollbarlargestep,
                theme: this.theme,
                _triggervaluechanged: false
            });
            this.hScrollBar = f.jqxScrollBar({
                vertical: false,
                rtl: this.rtl,
                touchMode: this.touchmode,
                step: this.horizontalscrollbarstep,
                largestep: this.horizontalscrollbarlargestep,
                theme: this.theme,
                _triggervaluechanged: false
            });
            this.pager = this.host.find("#pager");
            this.pager[0].id = "pager" + this.element.id;
            this.toolbar = this.host.find("#toolbar");
            this.toolbar[0].id = "toolbar" + this.element.id;
            this.toolbar.addClass(this.toTP("jqx-grid-toolbar"));
            this.toolbar.addClass(this.toTP("jqx-widget-header"));
            this.statusbar = this.host.find("#statusbar");
            this.statusbar[0].id = "statusbar" + this.element.id;
            this.statusbar.addClass(this.toTP("jqx-grid-statusbar"));
            this.statusbar.addClass(this.toTP("jqx-widget-header"));
            this.pager.addClass(this.toTP("jqx-grid-pager"));
            this.pager.addClass(this.toTP("jqx-widget-header"));
            this.groupsheader = this.host.find("#groupsheader");
            this.groupsheader.addClass(this.toTP("jqx-grid-groups-header"));
            this.groupsheader.addClass(this.toTP("jqx-widget-header"));
            this.vScrollBar.css("visibility", "hidden");
            this.hScrollBar.css("visibility", "hidden");
            this.vScrollInstance = a.data(this.vScrollBar[0], "jqxScrollBar").instance;
            this.hScrollInstance = a.data(this.hScrollBar[0], "jqxScrollBar").instance;
            this.gridtable = null;
            this.isNestedGrid = this.host.parent() ? 9999 == this.host.parent().css("z-index") : false;
            this.touchdevice = this.isTouchDevice();
            if (this.localizestrings) {
                this.localizestrings();
                if (null != this.localization) this.localizestrings(this.localization, false);
            }
            if (this.rowdetailstemplate) {
                if (void 0 == this.rowdetailstemplate.rowdetails) this.rowdetailstemplate.rowdetails = "<div></div>";
                if (void 0 == this.rowdetailstemplate.rowdetailsheight) this.rowdetailstemplate.rowdetailsheight = 200;
                if (void 0 == this.rowdetailstemplate.rowdetailshidden) this.rowdetailstemplate.rowdetailshidden = true;
            }
            if (this.showfilterrow && !this.filterable) {
                throw new Error('jqxGrid: "showfilterrow" requires setting the "filterable" property to true!');
                this.host.remove();
                return;
            }
            if (this.autorowheight && !this.autoheight && !this.pageable) {
                throw new Error('jqxGrid: "autorowheight" requires setting the "autoheight" or "pageable" property to true!');
                this.host.remove();
                return;
            }
            if (this.virtualmode && null == this.rendergridrows) {
                throw new Error('jqxGrid: "virtualmode" requires setting the "rendergridrows"!');
                this.host.remove();
                return;
            }
            if (this.virtualmode && !this.pageable && this.groupable) {
                throw new Error('jqxGrid: "grouping" in "virtualmode" without paging is not supported!');
                this.host.remove();
                return;
            }
            if (this._testmodules()) return;
            this._builddataloadelement();
            this._cachedcolumns = this.columns;
            if (25 != this.rowsheight) this._measureElement("cell");
            if (25 != this.columnsheight || this.columngroups) this._measureElement("column");
            if (this.source) {
                var d = this.source.datafields;
                if (null == d && this.source._source) d = this.source._source.datafields;
                if (d) for (var g = 0; g < this.columns.length; g++) {
                    var h = this.columns[g];
                    if (h && h.cellsformat && h.cellsformat.length > 2) for (var i = 0; i < d.length; i++) if (d[i].name == h.datafield && !d[i].format) {
                        d[i].format = h.cellsformat;
                        break;
                    }
                }
            }
            this.databind(this.source);
            if (this.showtoolbar) this.toolbar.css("visibility", "inherit");
            if (this.showstatusbar) this.statusbar.css("visibility", "inherit");
            this._arrange();
            if (this.pageable && this._initpager) this._initpager();
            this.tableheight = null;
            var j = this.that;
            var k = function() {
                if (j.content) {
                    j.content[0].scrollTop = 0;
                    j.content[0].scrollLeft = 0;
                }
                if (j.gridcontent) {
                    j.gridcontent[0].scrollLeft = 0;
                    j.gridcontent[0].scrollTop = 0;
                }
            };
            this.addHandler(this.content, "mousedown", function() {
                k();
            });
            this.addHandler(this.content, "scroll", function(a) {
                k();
                return false;
            });
            if (!this.showfilterrow) {
                if (!this.showstatusbar && !this.showtoolbar) this.host.addClass("jqx-disableselect");
                this.content.addClass("jqx-disableselect");
            }
            if (this.enablebrowserselection) {
                this.content.removeClass("jqx-disableselect");
                this.host.removeClass("jqx-disableselect");
            }
            this._resizeWindow();
            if (this.disabled) this.host.addClass(this.toThemeProperty("jqx-fill-state-disabled"));
            this.hasTransform = a.jqx.utilities.hasTransform(this.host);
            if ("logical" == this.scrollmode) {
                this.vScrollInstance.thumbStep = this.rowsheight;
                this.vScrollInstance.step = this.rowsheight;
            }
            if (!a.jqx.isHidden(this.host)) if (this.filterable || this.groupable || this.sortable) this._initmenu();
        },
        _resizeWindow: function() {
            var b = this.that;
            if (null != this.width && this.width.toString().indexOf("%") != -1 || null != this.height && this.height.toString().indexOf("%") != -1) {
                this._updatesizeonwindowresize = true;
                a.jqx.utilities.resize(this.host, function(c) {
                    var d = a(window).width();
                    var e = a(window).height();
                    var f = b.host.width();
                    var g = b.host.height();
                    if (b.autoheight) b._lastHostWidth = e;
                    if (b._lastHostWidth != f || b._lastHostHeight != g) {
                        if (b.touchdevice && b.editcell && "orientationchange" !== c) return;
                        b._updatesize(b._lastHostWidth != f, b._lastHostHeight != g);
                    }
                    b._lastWidth = d;
                    b._lastHeight = e;
                    b._lastHostWidth = f;
                    b._lastHostHeight = g;
                });
                var c = b.host.width();
                var d = b.host.height();
                b._lastHostWidth = c;
                b._lastHostHeight = d;
            }
        },
        _builddataloadelement: function() {
            if (this.dataloadelement) this.dataloadelement.remove();
            this.dataloadelement = a('<div style="overflow: hidden; position: absolute;"></div>');
            if (this.showdefaultloadelement) {
                var b = a('<div style="z-index: 99999; margin-left: -66px; left: 50%; top: 50%; margin-top: -24px; position: relative; width: 100px; height: 33px; padding: 5px; font-family: verdana; font-size: 12px; color: #767676; border-color: #898989; border-width: 1px; border-style: solid; background: #f6f6f6; border-collapse: collapse;"><div style="float: left;"><div style="float: left; overflow: hidden; width: 32px; height: 32px;" class="jqx-grid-load"/><span style="margin-top: 10px; float: left; display: block; margin-left: 5px;" >' + this.gridlocalization.loadtext + "</span></div></div>");
                b.addClass(this.toTP("jqx-rc-all"));
                this.dataloadelement.addClass(this.toTP("jqx-rc-all"));
                b.addClass(this.toTP("jqx-fill-state-normal"));
                this.dataloadelement.append(b);
            } else this.dataloadelement.addClass(this.toTP("jqx-grid-load"));
            this.dataloadelement.width(this.width);
            this.dataloadelement.height(this.height);
            this.host.prepend(this.dataloadelement);
        },
        _measureElement: function(b) {
            var c = a("<span style='visibility: hidden; white-space: nowrap;'>measure Text</span>");
            c.addClass(this.toTP("jqx-widget"));
            a(document.body).append(c);
            if ("cell" == b) this._cellheight = c.height(); else this._columnheight = c.height();
            c.remove();
        },
        _measureMenuElement: function() {
            var b = a("<span style='visibility: hidden; white-space: nowrap;'>measure Text</span>");
            b.addClass(this.toTP("jqx-widget"));
            b.addClass(this.toTP("jqx-menu"));
            b.addClass(this.toTP("jqx-menu-item-top"));
            b.addClass(this.toTP("jqx-fill-state-normal"));
            a(document.body).append(b);
            var c = b.outerHeight();
            b.remove();
            return c;
        },
        _measureElementWidth: function(b) {
            var c = a("<span style='visibility: hidden; white-space: nowrap;'>" + b + "</span>");
            c.addClass(this.toTP("jqx-widget"));
            c.addClass(this.toTP("jqx-grid"));
            c.addClass(this.toTP("jqx-grid-column-header"));
            c.addClass(this.toTP("jqx-widget-header"));
            a(document.body).append(c);
            var d = c.outerWidth() + 20;
            c.remove();
            return d;
        },
        _getBodyOffset: function() {
            var b = 0;
            var c = 0;
            if ("0px" != a("body").css("border-top-width")) {
                b = parseInt(a("body").css("border-top-width"));
                if (isNaN(b)) b = 0;
            }
            if ("0px" != a("body").css("border-left-width")) {
                c = parseInt(a("body").css("border-left-width"));
                if (isNaN(c)) c = 0;
            }
            return {
                left: c,
                top: b
            };
        },
        _testmodules: function() {
            var b = "";
            var c = this.that;
            var d = function() {
                if ("" != b.length) b += ",";
            };
            if (this.columnsmenu && !this.host.jqxMenu && (this.sortable || this.groupable || this.filterable)) {
                d();
                b += " jqxmenu.js";
            }
            if (!this.host.jqxScrollBar) {
                d();
                b += " jqxscrollbar.js";
            }
            if (!this.host.jqxButton) {
                d();
                b += " jqxbuttons.js";
            }
            if (!a.jqx.dataAdapter) {
                d();
                b += " jqxdata.js";
            }
            if (this.pageable && !this.gotopage) {
                d();
                b += "jqxgrid.pager.js";
            }
            if (this.filterable && !this.applyfilters) {
                d();
                b += " jqxgrid.filter.js";
            }
            if (this.groupable && !this._initgroupsheader) {
                d();
                b += " jqxgrid.grouping.js";
            }
            if (this.columnsresize && !this.autoresizecolumns) {
                d();
                b += " jqxgrid.columnsresize.js";
            }
            if (this.columnsreorder && !this.setcolumnindex) {
                d();
                b += " jqxgrid.columnsreorder.js";
            }
            if (this.sortable && !this.sortby) {
                d();
                b += " jqxgrid.sort.js";
            }
            if (this.editable && !this.begincelledit) {
                d();
                b += " jqxgrid.edit.js";
            }
            if (this.showaggregates && !this.getcolumnaggregateddata) {
                d();
                b += " jqxgrid.aggregates.js";
            }
            if (this.keyboardnavigation && !this.selectrow) {
                d();
                b += " jqxgrid.selection.js";
            }
            if ("" != b || this.editable || this.filterable || this.pageable) {
                var e = [];
                var f = function(a) {
                    switch (a) {
                        case "checkbox":
                            if (!c.host.jqxCheckBox && !e.checkbox) {
                                e.checkbox = true;
                                d();
                                b += " jqxcheckbox.js";
                            }
                            break;

                        case "numberinput":
                            if (!c.host.jqxNumberInput && !e.numberinput) {
                                e.numberinput = true;
                                d();
                                b += " jqxnumberinput.js";
                            }
                            break;

                        case "datetimeinput":
                            if (!c.host.jqxDateTimeInput && !e.datetimeinput) {
                                d();
                                e.datetimeinput = true;
                                b += " jqxdatetimeinput.js(requires: jqxcalendar.js)";
                            } else if (!c.host.jqxCalendar && !e.calendar) {
                                d();
                                b += " jqxcalendar.js";
                            }
                            break;

                        case "combobox":
                            if (!c.host.jqxComboBox && !e.combobox) {
                                d();
                                e.combobox = true;
                                b += " jqxcombobox.js(requires: jqxlistbox.js)";
                            } else if (!c.host.jqxListBox && !e.listbox) {
                                d();
                                e.listbox = true;
                                b += " jqxlistbox.js";
                            }
                            break;

                        case "dropdownlist":
                            if (!c.host.jqxDropDownList && !e.dropdownlist) {
                                d();
                                e.dropdownlist = true;
                                b += " jqxdropdownlist.js(requires: jqxlistbox.js)";
                            } else if (!c.host.jqxListBox && !e.listbox) {
                                d();
                                e.listbox = true;
                                b += " jqxlistbox.js";
                            }
                    }
                };
                if (this.filterable || this.pageable) f("dropdownlist");
                for (var g = 0; g < this.columns.length; g++) {
                    if (void 0 == this.columns[g]) continue;
                    var h = this.columns[g].columntype;
                    f(h);
                    if (this.filterable && this.showfilterrow) {
                        var h = this.columns[g].filtertype;
                        if ("checkedlist" == h || "bool" == h) f("checkbox");
                        if ("date" == h) f("datetimeinput");
                    }
                }
                if ("" != b) {
                    throw new Error("jqxGrid: Missing references to the following module(s): " + b);
                    this.host.remove();
                    return true;
                }
            }
            return false;
        },
        focus: function() {
            try {
                this.wrapper.focus();
                var a = this.that;
                setTimeout(function() {
                    a.wrapper.focus();
                }, 25);
                this.focused = true;
            } catch (b) {}
        },
        hiddenParent: function() {
            return a.jqx.isHidden(this.host);
        },
        resize: function(a, b) {
            this.width = a;
            this.height = b;
            this._updatesize(true, true);
        },
        _updatesize: function(b, c) {
            if (this._loading) return;
            var d = this.that;
            d._newmax = null;
            var e = d.host.width();
            var f = d.host.height();
            if (!d._oldWidth) d._oldWidth = e;
            if (!d._oldHeight) d._oldHeight = f;
            if (d._resizeTimer) clearTimeout(d._resizeTimer);
            var g = 5;
            d._resizeTimer = setTimeout(function() {
                d.resizingGrid = true;
                if (a.jqx.isHidden(d.host)) return;
                if (d.editcell) {
                    d.endcelledit(d.editcell.row, d.editcell.column, true, true);
                    d._oldselectedcell = null;
                }
                if (h != d._oldHeight || true == c) {
                    var f = d.groupable && d.groups.length > 0;
                    var g = d.vScrollBar.css("visibility");
                    if (!d.autoheight) {
                        if (d.virtualmode) d._pageviews = new Array();
                        if (!f && !d.rowdetails && !d.pageable) {
                            d._arrange();
                            d.virtualsizeinfo = d._calculatevirtualheight();
                            var h = Math.round(d.host.height()) + 2 * d.rowsheight;
                            if (parseInt(h) >= parseInt(d._oldHeight)) d.prerenderrequired = true;
                            d._renderrows(d.virtualsizeinfo);
                        } else {
                            d._arrange();
                            d.prerenderrequired = true;
                            var h = Math.round(d.host.height()) + 2 * d.rowsheight;
                            realheight = d._gettableheight();
                            var i = Math.round(h / d.rowsheight);
                            var j = Math.max(d.dataview.totalrows, d.dataview.totalrecords);
                            if (d.pageable) {
                                j = d.pagesize;
                                if (d.pagesize > Math.max(d.dataview.totalrows, d.dataview.totalrecords) && d.autoheight) j = Math.max(d.dataview.totalrows, d.dataview.totalrecords); else if (!d.autoheight) if (d.dataview.totalrows < d.pagesize) j = Math.max(d.dataview.totalrows, d.dataview.totalrecords);
                            }
                            var k = j * d.rowsheight;
                            var l = d._getpagesize();
                            if (!d.pageable && d.autoheight) i = j;
                            if (d.virtualsizeinfo) d.virtualsizeinfo.visiblerecords = i;
                            d.rendergridcontent(true, false);
                            d._renderrows(d.virtualsizeinfo);
                        }
                        if (g != d.vScrollBar.css("visibility")) {
                            d.vScrollInstance.setPosition(0);
                            d._arrange();
                            d._updatecolumnwidths();
                            if (d.table) d.table.width(d.columnsheader.width());
                            d._updatecellwidths();
                        }
                    }
                }
                if (e != d._oldWidth || true == b) {
                    var m = false;
                    if (d.editcell && d.editcell.editor) switch (d.editcell.columntype) {
                        case "dropdownlist":
                            m = d.editcell.editor.jqxDropDownList("isOpened") || d.editcell.editor.jqxDropDownList("isanimating") && !d.editcell.editor.jqxDropDownList("ishiding");
                            if (m) {
                                d.editcell.editor.jqxDropDownList({
                                    openDelay: 0
                                });
                                d.editcell.editor.jqxDropDownList("open");
                                d.editcell.editor.jqxDropDownList({
                                    openDelay: 250
                                });
                                return;
                            }
                            break;

                        case "combobox":
                            m = d.editcell.editor.jqxComboBox("isOpened") || d.editcell.editor.jqxComboBox("isanimating") && !d.editcell.editor.jqxComboBox("ishiding");
                            if (m) {
                                d.editcell.editor.jqxComboBox({
                                    openDelay: 0
                                });
                                d.editcell.editor.jqxComboBox("open");
                                d.editcell.editor.jqxComboBox({
                                    openDelay: 250
                                });
                                return;
                            }
                            break;

                        case "datetimeinput":
                            if (m) {
                                m = d.editcell.editor.jqxDateTimeInput("isOpened") || d.editcell.editor.jqxDateTimeInput("isanimating") && !d.editcell.editor.jqxDateTimeInput("ishiding");
                                d.editcell.editor.jqxDateTimeInput({
                                    openDelay: 0
                                });
                                d.editcell.editor.jqxDateTimeInput("open");
                                d.editcell.editor.jqxDateTimeInput({
                                    openDelay: 250
                                });
                                return;
                            }
                    }
                    var n = d.hScrollBar.css("visibility");
                    d._arrange();
                    d._updatecolumnwidths();
                    if (d.table) d.table.width(d.columnsheader.width());
                    d._updatecellwidths();
                    if (!(false == b && d._oldWidth > e)) if (!c || 0 == d.dataview.rows.length) d._renderrows(d.virtualsizeinfo);
                    if (n != d.hScrollBar.css("visibility")) d.hScrollInstance.setPosition(0);
                }
                d._oldWidth = e;
                d._oldHeight = h;
                d.resizingGrid = false;
            }, g);
        },
        getTouches: function(b) {
            return a.jqx.mobile.getTouches(b);
        },
        _updateTouchScrolling: function() {
            var b = this.that;
            if (b.isTouchDevice()) {
                b.scrollmode = "logical";
                b.vScrollInstance.thumbStep = b.rowsheight;
                var c = a.jqx.mobile.getTouchEventName("touchstart");
                var d = a.jqx.mobile.getTouchEventName("touchend");
                var e = a.jqx.mobile.getTouchEventName("touchmove");
                b.enablehover = false;
                if (b.gridcontent) {
                    b.removeHandler(b.gridcontent, c + ".touchScroll");
                    b.removeHandler(b.gridcontent, e + ".touchScroll");
                    b.removeHandler(b.gridcontent, d + ".touchScroll");
                    b.removeHandler(b.gridcontent, "touchcancel.touchScroll");
                    a.jqx.mobile.touchScroll(b.gridcontent[0], b.vScrollInstance.max, function(a, c) {
                        if ("visible" == b.vScrollBar.css("visibility")) {
                            var d = b.vScrollInstance.value;
                            b.vScrollInstance.setPosition(d + c);
                        }
                        if ("visible" == b.hScrollBar.css("visibility")) {
                            var d = b.hScrollInstance.value;
                            b.hScrollInstance.setPosition(d + a);
                        }
                        b.vScrollInstance.thumbCapture = true;
                        b._lastScroll = new Date();
                    }, this.element.id, this.hScrollBar, this.vScrollBar);
                    if (b._overlayElement) {
                        b.removeHandler(b._overlayElement, c + ".touchScroll");
                        b.removeHandler(b._overlayElement, e + ".touchScroll");
                        b.removeHandler(b._overlayElement, d + ".touchScroll");
                        b.removeHandler(b._overlayElement, "touchcancel.touchScroll");
                        a.jqx.mobile.touchScroll(b._overlayElement[0], b.vScrollInstance.max, function(a, c) {
                            if ("visible" == b.vScrollBar.css("visibility")) {
                                var d = b.vScrollInstance.value;
                                b.vScrollInstance.setPosition(d + c);
                            }
                            if ("visible" == b.hScrollBar.css("visibility")) {
                                var d = b.hScrollInstance.value;
                                b.hScrollInstance.setPosition(d + a);
                            }
                            b.vScrollInstance.thumbCapture = true;
                            b._lastScroll = new Date();
                        }, this.element.id, this.hScrollBar, this.vScrollBar);
                        this.addHandler(this.host, c, function() {
                            if (!b.editcell) b._overlayElement.css("visibility", "visible"); else b._overlayElement.css("visibility", "hidden");
                        });
                        this.addHandler(this.host, d, function() {
                            if (!b.editcell) b._overlayElement.css("visibility", "visible"); else b._overlayElement.css("visibility", "hidden");
                        });
                    }
                }
            }
        },
        isTouchDevice: function() {
            if (void 0 != this.touchDevice) return this.touchDevice;
            var b = a.jqx.mobile.isTouchDevice();
            this.touchDevice = b;
            if (true == this.touchmode) {
                if (a.jqx.browser.msie && a.jqx.browser.version < 9) {
                    this.enablehover = false;
                    return false;
                }
                b = true;
                a.jqx.mobile.setMobileSimulator(this.element);
                this.touchDevice = b;
            } else if (false == this.touchmode) b = false;
            if (b && false != this.touchModeStyle) {
                this.touchDevice = true;
                this.host.addClass(this.toThemeProperty("jqx-touch"));
                this.host.find("jqx-widget-content").addClass(this.toThemeProperty("jqx-touch"));
                this.host.find("jqx-widget-header").addClass(this.toThemeProperty("jqx-touch"));
                this.scrollbarsize = this.touchscrollbarsize;
            }
            return b;
        },
        toTP: function(a) {
            return this.toThemeProperty(a);
        },
        localizestrings: function(b, c) {
            this._cellscache = new Array();
            if (a.jqx.dataFormat) a.jqx.dataFormat.cleardatescache();
            if (this._loading) {
                throw new Error("jqxGrid: " + this.loadingerrormessage);
                return false;
            }
            if (null != b) {
                for (var d in b) if (d.toLowerCase() !== d) b[d.toLowerCase()] = b[d];
                if (b.pagergotopagestring) this.gridlocalization.pagergotopagestring = b.pagergotopagestring;
                if (b.pagershowrowsstring) this.gridlocalization.pagershowrowsstring = b.pagershowrowsstring;
                if (b.pagerrangestring) this.gridlocalization.pagerrangestring = b.pagerrangestring;
                if (b.pagernextbuttonstring) this.gridlocalization.pagernextbuttonstring = b.pagernextbuttonstring;
                if (b.pagerpreviousbuttonstring) this.gridlocalization.pagerpreviousbuttonstring = b.pagerpreviousbuttonstring;
                if (b.pagerfirstbuttonstring) this.gridlocalization.pagerfirstbuttonstring = b.pagerfirstbuttonstring;
                if (b.pagerlastbuttonstring) this.gridlocalization.pagerlastbuttonstring = b.pagerlastbuttonstring;
                if (b.groupsheaderstring) this.gridlocalization.groupsheaderstring = b.groupsheaderstring;
                if (b.sortascendingstring) this.gridlocalization.sortascendingstring = b.sortascendingstring;
                if (b.sortdescendingstring) this.gridlocalization.sortdescendingstring = b.sortdescendingstring;
                if (b.sortremovestring) this.gridlocalization.sortremovestring = b.sortremovestring;
                if (b.groupbystring) this.gridlocalization.groupbystring = b.groupbystring;
                if (b.groupremovestring) this.gridlocalization.groupremovestring = b.groupremovestring;
                if (b.firstDay) this.gridlocalization.firstDay = b.firstDay;
                if (b.days) this.gridlocalization.days = b.days;
                if (b.months) this.gridlocalization.months = b.months;
                if (b.AM) this.gridlocalization.AM = b.AM;
                if (b.PM) this.gridlocalization.PM = b.PM;
                if (b.patterns) this.gridlocalization.patterns = b.patterns;
                if (b.percentsymbol) this.gridlocalization.percentsymbol = b.percentsymbol;
                if (b.currencysymbol) this.gridlocalization.currencysymbol = b.currencysymbol;
                if (b.currencysymbolposition) this.gridlocalization.currencysymbolposition = b.currencysymbolposition;
                if (void 0 != b.decimalseparator) this.gridlocalization.decimalseparator = b.decimalseparator;
                if (void 0 != b.thousandsseparator) this.gridlocalization.thousandsseparator = b.thousandsseparator;
                if (b.filterclearstring) this.gridlocalization.filterclearstring = b.filterclearstring;
                if (b.filterstring) this.gridlocalization.filterstring = b.filterstring;
                if (b.filtershowrowstring) this.gridlocalization.filtershowrowstring = b.filtershowrowstring;
                if (b.filtershowrowdatestring) this.gridlocalization.filtershowrowdatestring = b.filtershowrowdatestring;
                if (b.filterselectallstring) this.gridlocalization.filterselectallstring = b.filterselectallstring;
                if (b.filterchoosestring) this.gridlocalization.filterchoosestring = b.filterchoosestring;
                if (b.filterorconditionstring) this.gridlocalization.filterorconditionstring = b.filterorconditionstring;
                if (b.filterandconditionstring) this.gridlocalization.filterandconditionstring = b.filterandconditionstring;
                if (b.filterstringcomparisonoperators) this.gridlocalization.filterstringcomparisonoperators = b.filterstringcomparisonoperators;
                if (b.filternumericcomparisonoperators) this.gridlocalization.filternumericcomparisonoperators = b.filternumericcomparisonoperators;
                if (b.filterdatecomparisonoperators) this.gridlocalization.filterdatecomparisonoperators = b.filterdatecomparisonoperators;
                if (b.filterbooleancomparisonoperators) this.gridlocalization.filterbooleancomparisonoperators = b.filterbooleancomparisonoperators;
                if (b.emptydatastring) this.gridlocalization.emptydatastring = b.emptydatastring;
                if (b.filterselectstring) this.gridlocalization.filterselectstring = b.filterselectstring;
                if (b.todaystring) this.gridlocalization.todaystring = b.todaystring;
                if (b.clearstring) this.gridlocalization.clearstring = b.clearstring;
                if (b.validationstring) this.gridlocalization.validationstring = b.validationstring;
                if (b.loadtext) this.gridlocalization.loadtext = b.loadtext;
                if (false !== c) {
                    if (this._initpager) this._initpager();
                    if (this._initgroupsheader) this._initgroupsheader();
                    if (this._initmenu) this._initmenu();
                    this._builddataloadelement();
                    a(this.dataloadelement).css("visibility", "hidden");
                    a(this.dataloadelement).css("display", "none");
                    if (this.filterable && this.showfilterrow) if (this._updatefilterrow) {
                        for (var d in this._filterrowcache) a(this._filterrowcache[d]).remove();
                        this._filterrowcache = [];
                        this._updatefilterrow();
                    }
                    if (this.showaggregates && this.refresheaggregates) this.refresheaggregates();
                    this._renderrows(this.virtualsizeinfo);
                }
            } else this.gridlocalization = {
                "/": "/",
                ":": ":",
                firstDay: 0,
                days: {
                    names: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
                    namesAbbr: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
                    namesShort: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ]
                },
                months: {
                    names: [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "" ],
                    namesAbbr: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "" ]
                },
                AM: [ "AM", "am", "AM" ],
                PM: [ "PM", "pm", "PM" ],
                eras: [ {
                    name: "A.D.",
                    start: null,
                    offset: 0
                } ],
                twoDigitYearMax: 2029,
                patterns: {
                    d: "M/d/yyyy",
                    D: "dddd, MMMM dd, yyyy",
                    t: "h:mm tt",
                    T: "h:mm:ss tt",
                    f: "dddd, MMMM dd, yyyy h:mm tt",
                    F: "dddd, MMMM dd, yyyy h:mm:ss tt",
                    M: "MMMM dd",
                    Y: "yyyy MMMM",
                    S: "yyyy'-'MM'-'dd'T'HH':'mm':'ss",
                    ISO: "yyyy-MM-dd hh:mm:ss",
                    ISO2: "yyyy-MM-dd HH:mm:ss",
                    d1: "dd.MM.yyyy",
                    d2: "dd-MM-yyyy",
                    d3: "dd-MMMM-yyyy",
                    d4: "dd-MM-yy",
                    d5: "H:mm",
                    d6: "HH:mm",
                    d7: "HH:mm tt",
                    d8: "dd/MMMM/yyyy",
                    d9: "MMMM-dd",
                    d10: "MM-dd",
                    d11: "MM-dd-yyyy"
                },
                percentsymbol: "%",
                currencysymbol: "$",
                currencysymbolposition: "before",
                decimalseparator: ".",
                thousandsseparator: ",",
                pagergotopagestring: "Go to page:",
                pagershowrowsstring: "Show rows:",
                pagerrangestring: " of ",
                pagerpreviousbuttonstring: "previous",
                pagernextbuttonstring: "next",
                pagerfirstbuttonstring: "first",
                pagerlastbuttonstring: "last",
                groupsheaderstring: "Drag a column and drop it here to group by that column",
                sortascendingstring: "Sort Ascending",
                sortdescendingstring: "Sort Descending",
                sortremovestring: "Remove Sort",
                groupbystring: "Group By this column",
                groupremovestring: "Remove from groups",
                filterclearstring: "Clear",
                filterstring: "Filter",
                filtershowrowstring: "Show rows where:",
                filtershowrowdatestring: "Show rows where date:",
                filterorconditionstring: "Or",
                filterandconditionstring: "And",
                filterselectallstring: "(Select All)",
                filterchoosestring: "Please Choose:",
                filterstringcomparisonoperators: [ "empty", "not empty", "contains", "contains(match case)", "does not contain", "does not contain(match case)", "starts with", "starts with(match case)", "ends with", "ends with(match case)", "equal", "equal(match case)", "null", "not null" ],
                filternumericcomparisonoperators: [ "equal", "not equal", "less than", "less than or equal", "greater than", "greater than or equal", "null", "not null" ],
                filterdatecomparisonoperators: [ "equal", "not equal", "less than", "less than or equal", "greater than", "greater than or equal", "null", "not null" ],
                filterbooleancomparisonoperators: [ "equal", "not equal" ],
                validationstring: "Entered value is not valid",
                emptydatastring: "No data to display",
                filterselectstring: "Select Filter",
                loadtext: "Loading...",
                clearstring: "Clear",
                todaystring: "Today"
            };
        },
        _initmenu: function() {
            var b = this.that;
            if (this.host.jqxMenu) {
                if (this.gridmenu) {
                    if (this._hasOpenedMenu) return;
                    if (this.filterable) if (this._destroyfilterpanel) this._destroyfilterpanel();
                    this.removeHandler(this.gridmenu, "keydown");
                    this.removeHandler(this.gridmenu, "closed");
                    this.removeHandler(this.gridmenu, "itemclick");
                    this.gridmenu.jqxMenu("destroy");
                    this.gridmenu.removeData();
                    this.gridmenu.remove();
                }
                this.menuitemsarray = new Array();
                this.gridmenu = a('<div id="gridmenu' + this.element.id + '" style="z-index: 9999999999999;"></div>');
                this.host.append(this.gridmenu);
                var c = a("<ul></ul>");
                var d = '<div class="jqx-grid-sortasc-icon"></div>';
                var e = a("<li>" + d + this.gridlocalization.sortascendingstring + "</li>");
                var f = '<div class="jqx-grid-sortdesc-icon"></div>';
                var g = a("<li>" + f + this.gridlocalization.sortdescendingstring + "</li>");
                var h = '<div class="jqx-grid-sortremove-icon"></div>';
                var i = a("<li>" + h + this.gridlocalization.sortremovestring + "</li>");
                var j = '<div class="jqx-grid-groupby-icon"></div>';
                var k = a("<li>" + j + this.gridlocalization.groupbystring + "</li>");
                var l = a("<li>" + j + this.gridlocalization.groupremovestring + "</li>");
                var m = a('<li type="separator"></li>');
                var n = a('<li class="filter" style="height: 175px;" ignoretheme="true"><div class="filter"></div></li>');
                var o = this.gridlocalization.sortascendingstring.length;
                var p = this.gridlocalization.sortascendingstring;
                if (this.gridlocalization.sortdescendingstring.length > o) {
                    o = this.gridlocalization.sortdescendingstring.length;
                    p = this.gridlocalization.sortdescendingstring;
                }
                if (this.gridlocalization.sortremovestring.length > o) {
                    o = this.gridlocalization.sortremovestring.length;
                    p = this.gridlocalization.sortremovestring;
                }
                if (this.groupable && this._initgroupsheader && this.showgroupmenuitems) {
                    if (this.gridlocalization.groupbystring.length > o) {
                        o = this.gridlocalization.groupbystring.length;
                        p = this.gridlocalization.groupbystring;
                    }
                    if (this.gridlocalization.groupremovestring.length > o) {
                        o = this.gridlocalization.groupremovestring.length;
                        p = this.gridlocalization.groupremovestring;
                    }
                }
                var q = 200;
                p = a.trim(p).replace(/\&nbsp\;/gi, "").replace(/\&#160\;/gi, "");
                var r = a("<span>" + p + "</span>");
                r.addClass(this.toThemeProperty("jqx-menu-item"));
                this.host.append(r);
                q = r.outerWidth() + 60;
                r.remove();
                var s = 0;
                if (this.sortable && this._togglesort && this.showsortmenuitems) {
                    c.append(e);
                    this.menuitemsarray[0] = e[0];
                    c.append(g);
                    this.menuitemsarray[1] = g[0];
                    c.append(i);
                    this.menuitemsarray[2] = i[0];
                    s = 3;
                }
                if (this.groupable && this._initgroupsheader && this.showgroupmenuitems) {
                    c.append(k);
                    this.menuitemsarray[3] = k[0];
                    c.append(l);
                    this.menuitemsarray[4] = l[0];
                    s += 2;
                }
                var t = this._measureMenuElement();
                var u = s * t + 9;
                var v = true;
                if (this.filterable && !this.showfilterrow && this.showfiltermenuitems) if (this._initfilterpanel) {
                    this.menuitemsarray[5] = n[0];
                    this.menuitemsarray[6] = n[0];
                    c.append(m);
                    c.append(n);
                    u += 180;
                    if (a.jqx.browser.msie && a.jqx.browser.version < 8) u += 20;
                    var w = a(n).find("div:first");
                    q += 20;
                    this._initfilterpanel(this, w, "", q);
                    v = false;
                    this.removeHandler(a(document), "click.menu" + b.element.id, b._closemenuafterclick, b);
                    this.addHandler(a(document), "click.menu" + b.element.id, b._closemenuafterclick, b);
                } else throw new Error("jqxGrid: Missing reference to jqxgrid.filter.js.");
                this.gridmenu.append(c);
                if (a.jqx.browser.msie && a.jqx.browser.version < 8 && this.filterable) {
                    a("#listBoxfilter1" + this.element.id).css("z-index", 4990);
                    a("#listBoxfilter2" + this.element.id).css("z-index", 4990);
                    a("#listBoxfilter3" + this.element.id).css("z-index", 4990);
                    a("#gridmenu" + this.element.id).css("z-index", 5e3);
                    this.addHandler(a("#gridmenu" + this.element.id), "initialized", function() {
                        a("#menuWrappergridmenu" + b.element.id).css("z-index", 4980);
                    });
                }
                if (void 0 == this.menuitemsarray[0]) u = 65;
                this.removeHandler(this.gridmenu, "keydown");
                this.addHandler(this.gridmenu, "keydown", function(c) {
                    if (27 == c.keyCode) b.gridmenu.jqxMenu("close"); else if (13 == c.keyCode && b.filterable) if (b._buildfilter) {
                        var d = "block" == a(a.find("#filter1" + b.element.id)).jqxDropDownList("container").css("display");
                        var e = "block" == a(a.find("#filter2" + b.element.id)).jqxDropDownList("container").css("display");
                        var f = "block" == a(a.find("#filter3" + b.element.id)).jqxDropDownList("container").css("display");
                        var g = a(a.find("#filterclearbutton" + b.element.id)).hasClass("jqx-fill-state-focus");
                        if (g) {
                            var h = a.data(document.body, "contextmenu" + b.element.id).column;
                            b._clearfilter(b, b.element, h);
                            b.gridmenu.jqxMenu("close");
                        } else if (!d && !e && !f) {
                            var h = a.data(document.body, "contextmenu" + b.element.id).column;
                            b.gridmenu.jqxMenu("close");
                            b._buildfilter(b, n, h);
                        }
                    }
                });
                if ("auto" != this.popupwidth) q = this.popupwidth;
                this.gridmenu.jqxMenu({
                    popupZIndex: 999999,
                    width: q,
                    height: u,
                    autoCloseOnClick: v,
                    autoOpenPopup: false,
                    mode: "popup",
                    theme: this.theme,
                    animationShowDuration: 0,
                    animationHideDuration: 0,
                    animationShowDelay: 0
                });
                if (this.filterable) this.gridmenu.jqxMenu("_setItemProperty", n[0].id, "closeOnClick", false);
                if (this.rtl) {
                    var x = this.that;
                    a.each(c.find("li"), function() {
                        a(this).addClass(x.toTP("jqx-rtl"));
                    });
                    var y = function(a) {
                        var b = a.find("div");
                        b.css("float", "right");
                        b.css("margin-left", "4px");
                        b.css("margin-right", "-4px");
                    };
                    y(i);
                    y(g);
                    y(e);
                    y(k);
                    y(l);
                }
                this._handlemenueevents();
            } else this.columnsmenu = false;
        },
        _arrangemenu: function() {
            if (!this.gridmenu) this._initmenu();
            var b = this.gridlocalization.sortascendingstring.length;
            var c = this.gridlocalization.sortascendingstring;
            if (this.gridlocalization.sortdescendingstring.length > b) {
                b = this.gridlocalization.sortdescendingstring.length;
                c = this.gridlocalization.sortdescendingstring;
            }
            if (this.gridlocalization.sortremovestring.length > b) {
                b = this.gridlocalization.sortremovestring.length;
                c = this.gridlocalization.sortremovestring;
            }
            if (this.groupable && this._initgroupsheader) {
                if (this.gridlocalization.groupbystring.length > b) {
                    b = this.gridlocalization.groupbystring.length;
                    c = this.gridlocalization.groupbystring;
                }
                if (this.gridlocalization.groupremovestring.length > b) {
                    b = this.gridlocalization.groupremovestring.length;
                    c = this.gridlocalization.groupremovestring;
                }
            }
            var d = 200;
            c = a.trim(c).replace(/\&nbsp\;/gi, "").replace(/\&#160\;/gi, "");
            var e = a("<span>" + c + "</span>");
            e.addClass(this.toThemeProperty("jqx-menu-item"));
            this.host.append(e);
            d = e.outerWidth() + 60;
            e.remove();
            var f = 0;
            if (this.sortable && this._togglesort && this.showsortmenuitems) f = 3;
            if (this.groupable && this._initgroupsheader && this.showgroupmenuitems) f += 2;
            var g = 27 * f + 3;
            if (this.filterable && this.showfiltermenuitems) if (this._initfilterpanel) {
                g += 180;
                d += 20;
                if (a.jqx.browser.msie && a.jqx.browser.version < 8) g += 20;
            }
            if (void 0 == this.menuitemsarray[0]) g = 65;
            if ("auto" != this.popupwidth) d = this.popupwidth;
            this.gridmenu.jqxMenu({
                width: d,
                height: g
            });
        },
        _closemenuafterclick: function(b) {
            var c = null != b ? b.data : this;
            var d = false;
            if (void 0 == b.target || void 0 != b.target && void 0 == b.target.className.indexOf) {
                c.gridmenu.jqxMenu("close");
                return;
            }
            if (b.target.className.indexOf("filter") != -1 && b.target.className.indexOf("jqx-grid-cell-filter") == -1) return;
            if (b.target.className.indexOf("jqx-grid-cell") != -1) {
                c.gridmenu.jqxMenu("close");
                return;
            }
            if (c._hasOpenedMenu) if (a(b.target).ischildof(c.gridmenu)) return;
            var e = c.host.coord();
            var f = c.gridmenu.coord();
            var g = b.pageX;
            var h = b.pageY;
            a.each(a(b.target).parents(), function() {
                if (null != this.id && this.id.indexOf && this.id.indexOf("filter") != -1) {
                    d = true;
                    return false;
                }
                if (this.className.indexOf && this.className.indexOf("filter") != -1 && this.className.indexOf("jqx-grid-cell-filter") == -1) {
                    d = true;
                    return false;
                }
                if (this.className.indexOf && this.className.indexOf("jqx-grid-cell") != -1) {
                    c.gridmenu.jqxMenu("close");
                    return false;
                }
                if (this.className.indexOf && this.className.indexOf("jqx-grid-column") != -1) {
                    c.gridmenu.jqxMenu("close");
                    return false;
                }
            });
            if (d) return;
            try {
                if ("default" === c.filtermode) {
                    var i = a(a.find("#filter1" + c.element.id)).jqxDropDownList("listBox").vScrollInstance._mouseup;
                    var j = new Date();
                    if (j - i < 100) return;
                    var k = a(a.find("#filter3" + c.element.id)).jqxDropDownList("listBox").vScrollInstance._mouseup;
                    if (j - k < 100) return;
                    if ("block" == a(a.find("#filter3" + c.element.id)).jqxDropDownList("container").css("display")) return;
                    if ("block" == a(a.find("#filter1" + c.element.id)).jqxDropDownList("container").css("display")) return;
                    if ("block" == a(a.find("#filter2" + c.element.id)).jqxDropDownList("container").css("display")) return;
                    if (c._hasdatefilter) if ("div" == a(".filtertext1" + c.element.id)[0].nodeName.toLowerCase()) {
                        if ("block" == a(".filtertext1" + c.element.id).jqxDateTimeInput("container").css("display")) return;
                        if ("block" == a(".filtertext2" + c.element.id).jqxDateTimeInput("container").css("display")) return;
                    }
                } else {
                    var i = a(a.find("#filter1" + c.element.id)).data().jqxListBox.instance.vScrollInstance._mouseup;
                    var j = new Date();
                    if (j - i < 100) return;
                    var k = a(a.find("#filter1" + c.element.id)).data().jqxListBox.instance.hScrollInstance._mouseup;
                    if (j - k < 100) return;
                }
            } catch (l) {}
            if (g >= f.left && g <= f.left + c.gridmenu.width()) if (h >= f.top && h <= f.top + c.gridmenu.height()) return;
            c.gridmenu.jqxMenu("close");
        },
        _handlemenueevents: function() {
            var b = this.that;
            this.removeHandler(this.gridmenu, "closed");
            this.addHandler(this.gridmenu, "closed", function(a) {
                b._closemenu();
            });
            this.removeHandler(this.gridmenu, "itemclick");
            this.addHandler(this.gridmenu, "itemclick", function(c) {
                var d = c.args;
                for (var e = 0; e < b.menuitemsarray.length; e++) {
                    var f = b.menuitemsarray[e];
                    if (d == f) {
                        if (void 0 != a(d).attr("ignoretheme")) return;
                        var g = a.data(document.body, "contextmenu" + b.element.id);
                        var h = g.column;
                        if (b.filterable) b.gridmenu.jqxMenu("close");
                        var i = h.displayfield;
                        if (null == i) i = h.datafield;
                        if (null != g) switch (e) {
                            case 0:
                                b.sortby(i, "ascending", null);
                                break;

                            case 1:
                                b.sortby(i, "descending", null);
                                break;

                            case 2:
                                b.sortby(i, null, null);
                                break;

                            case 3:
                                b.addgroup(h.datafield);
                                break;

                            case 4:
                                b.removegroup(h.datafield);
                                break;

                            case 5:
                                var j = a(b.menuitemsarray[6]);
                                a(j).css("display", "block");
                                break;

                            case 7:                        }
                        break;
                    }
                }
            });
        },
        getdatainformation: function() {
            var a = this.dataview.totalrecords;
            if (this.summaryrows) a += this.summaryrows.length;
            return {
                rowscount: a,
                sortinformation: this.getsortinformation(),
                paginginformation: this.getpaginginformation()
            };
        },
        getsortinformation: function() {
            return {
                sortcolumn: this.sortcolumn,
                sortdirection: this.sortdirection
            };
        },
        getpaginginformation: function() {
            return {
                pagenum: this.dataview.pagenum,
                pagesize: this.pagesize,
                pagescount: Math.ceil(this.dataview.totalrecords / this.pagesize)
            };
        },
        _updaterowsproperties: function() {
            this._updatehiddenrows();
            this._updaterowheights();
            this._updaterowdetails();
        },
        _updatehiddenrows: function() {
            var b = this.that;
            this.hiddens = new Array();
            var c = this.hiddenboundrows;
            a.each(c, function(a) {
                if (void 0 != this.index) {
                    var c = this.index;
                    var d = b.getrowvisibleindex(a);
                    b.hiddens[d] = this.hidden;
                }
            });
        },
        _updaterowheights: function() {
            var b = this.that;
            this.heights = new Array();
            var c = this.heightboundrows;
            a.each(c, function(a) {
                if (void 0 != this.index) {
                    var c = this.index;
                    var d = b.getrowvisibleindex(a);
                    b.heights[d] = this.height;
                }
            });
        },
        _updaterowdetails: function() {
            var b = this.that;
            this.details = new Array();
            var c = this.detailboundrows;
            a.each(c, function(a) {
                if (void 0 != this.index) {
                    var c = this.index;
                    var d = b.getrowvisibleindex(a);
                    b.details[d] = this.details;
                }
            });
        },
        _getmenuitembyindex: function(a) {
            if (void 0 == a) return null;
            return this.menuitemsarray[a];
        },
        openmenu: function(b) {
            if (this._openingmenu) return;
            this._openingmenu = true;
            this.closemenu();
            var c = this.getcolumn(b);
            if (!c.menu) return false;
            if (!this.gridmenu) this._initmenu();
            var d = c.columnsmenu;
            a(c.element).trigger("mouseenter");
            var e = this;
            for (var f = 0; f < e.columns.records.length; f++) if (e.columns.records[f].datafield != b) a(e.columns.records[f].element).trigger("mouseleave");
            setTimeout(function() {
                if ("block" == a(d)[0].style.display) a(d).trigger("click");
                e._openingmenu = false;
            }, 200);
        },
        closemenu: function() {
            this._closemenu();
        },
        _closemenu: function() {
            if (this._hasOpenedMenu) {
                if (null != this.gridmenu) this.gridmenu.jqxMenu("close");
                var b = a.data(document.body, "contextmenu" + this.element.id);
                var c = 16;
                if (null != b && this.autoshowcolumnsmenubutton) {
                    if (this.enableanimations) {
                        a(b.columnsmenu).animate({
                            "margin-left": 0
                        }, "fast", function() {
                            a(b.columnsmenu).css("display", "none");
                        });
                        var d = !this.rtl ? -32 : 0;
                        b.column.iconscontainer.animate({
                            "margin-left": d
                        }, "fast");
                    } else {
                        a(b.columnsmenu).css("display", "none");
                        var d = !this.rtl ? -32 : 0;
                        b.column.iconscontainer.css("margin-left", d);
                    }
                    a.data(document.body, "contextmenu" + this.element.id, null);
                }
                this._hasOpenedMenu = false;
                var e = this._getmenuitembyindex(5);
                if (e) {
                    var f = a(e).find("#filter1" + this.element.id);
                    var g = a(e).find("#filter2" + this.element.id);
                    var h = a(e).find("#filter3" + this.element.id);
                    if (f.length > 0 && "default" === this.filtermode) {
                        f.jqxDropDownList("hideListBox");
                        g.jqxDropDownList("hideListBox");
                        h.jqxDropDownList("hideListBox");
                    }
                }
            }
        },
        scrolloffset: function(a, b) {
            if (null == a || null == b || void 0 == a || void 0 == b) return;
            this.vScrollBar.jqxScrollBar("setPosition", a);
            this.hScrollBar.jqxScrollBar("setPosition", b);
        },
        scrollleft: function(a) {
            if (null == a || void 0 == a) return;
            if ("hidden" != this.hScrollBar.css("visibility")) this.hScrollBar.jqxScrollBar("setPosition", a);
        },
        scrolltop: function(a) {
            if (null == a || void 0 == a) return;
            if ("hidden" != this.vScrollBar.css("visibility")) this.vScrollBar.jqxScrollBar("setPosition", a);
        },
        beginupdate: function(a) {
            this._updating = true;
            this._datachanged = false;
            if (true === a) this._batchupdate = true;
        },
        endupdate: function() {
            this.resumeupdate();
        },
        resumeupdate: function() {
            this._updating = false;
            if (this._batchupdate) {
                this._batchupdate = false;
                this._datachanged = false;
                this.render();
                return;
            }
            if (true == this._datachanged) {
                var a = this.vScrollInstance.value;
                this.render(true, true, false);
                this._datachanged = false;
                if (0 != a && a < this.vScrollInstance.max) this.scrolltop(a);
            } else {
                this.rendergridcontent(true);
                this._renderrows(this.virtualsizeinfo);
            }
            if (this.showaggregates && this.renderaggregates) this.renderaggregates();
            this._updatecolumnwidths();
            this._updatecellwidths();
            this._renderrows(this.virtualsizeinfo);
        },
        updating: function() {
            return this._updating;
        },
        showloadelement: function() {
            if (this.renderloadelement) this.dataloadelement.html(this.renderloadelement());
            this.dataloadelement.width(this.host.width());
            this.dataloadelement.height(this.host.height());
            a(this.dataloadelement).css("visibility", "visible");
            a(this.dataloadelement).css("display", "block");
        },
        hideloadelement: function() {
            a(this.dataloadelement).css("visibility", "hidden");
            a(this.dataloadelement).css("display", "none");
        },
        _updatefocusedfilter: function() {
            var a = this.that;
            if (a.focusedfilter) {
                a.focusedfilter.focus();
                setTimeout(function() {
                    a.focusedfilter.focus();
                    if ("input" == a.focusedfilter[0].nodeName.toLowerCase()) {
                        var b = a.focusedfilter.val().length;
                        try {
                            if ("selectionStart" in a.focusedfilter[0]) a.focusedfilter[0].setSelectionRange(b, b); else {
                                var c = a.focusedfilter[0].createTextRange();
                                c.collapse(true);
                                c.moveEnd("character", b);
                                c.moveStart("character", b);
                                c.select();
                            }
                        } catch (d) {}
                    }
                }, 10);
            }
        },
        databind: function(b, c) {
            if (true === this.loadingstate) return;
            if ("block" == this.host.css("display")) if (this.autoshowloadelement) {
                a(this.dataloadelement).css("visibility", "visible");
                a(this.dataloadelement).css("display", "block");
                this.dataloadelement.width(this.host.width());
                this.dataloadelement.height(this.host.height());
                this._hideemptyrow();
            } else {
                a(this.dataloadelement).css("visibility", "hidden");
                a(this.dataloadelement).css("display", "none");
            }
            if (!this._initgroupsheader && this.groups.length > 0) this.groups = new Array();
            var d = this.that;
            if (null == b) b = {};
            if (!b.recordstartindex) b.recordstartindex = 0;
            if (!b.recordendindex) b.recordendindex = 0;
            if (void 0 == b.loadallrecords || null == b.loadallrecords) b.loadallrecords = true;
            if (void 0 == b.sortcomparer || null == b.sortcomparer) b.sortcomparer = null;
            if (void 0 == b.filter || null == b.filter) b.filter = null;
            if (void 0 == b.sort || null == b.sort) b.sort = null;
            if (void 0 == b.data || null == b.data) b.data = null;
            var e = null;
            if (null != b) e = void 0 != b._source ? b._source.url : b.url;
            this.dataview = this.dataview || new a.jqx.dataview();
            if (a.jqx.dataview.sort) a.extend(this.dataview, new a.jqx.dataview.sort());
            if (a.jqx.dataview.grouping) a.extend(this.dataview, new a.jqx.dataview.grouping());
            this.dataview.suspendupdate();
            this.dataview.pageable = this.pageable;
            this.dataview.groupable = this.groupable;
            this.dataview.groups = this.groups;
            this.dataview.virtualmode = this.virtualmode;
            this.dataview.grid = this;
            this.dataview._clearcaches();
            if (!this.pageable && this.virtualmode) this.loadondemand = true;
            if (!d.initializedcall) {
                if (b._source) if (this.sortable) {
                    if (void 0 != b._source.sortcolumn) {
                        this.sortcolumn = b._source.sortcolumn;
                        this.source.sortcolumn = this.sortcolumn;
                        this.dataview.sortfield = b._source.sortcolumn;
                        b._source.sortcolumn = null;
                    }
                    if (void 0 != b._source.sortdirection) {
                        this.dataview.sortfielddirection = b._source.sortdirection;
                        var f = b._source.sortdirection;
                        if ("a" == f || "asc" == f || "ascending" == f || true == f) var g = true; else var g = false;
                        if (null != f) this.sortdirection = {
                            ascending: g,
                            descending: !g
                        }; else this.sortdirection = {
                            ascending: false,
                            descending: false
                        };
                    }
                }
                if (this.pageable) if (b._source) {
                    if (void 0 != b._source.pagenum) this.dataview.pagenum = b._source.pagenum;
                    if (void 0 != b._source.pagesize) {
                        this.pagesize = b._source.pagesize;
                        this.dataview.pagesize = b._source.pagesize;
                    } else {
                        this.dataview.pagesize = b._source.pagesize;
                        if (void 0 == this.dataview.pagesize) this.dataview.pagesize = this.pagesize;
                    }
                }
                if (this.sortable) {
                    if (b.sortcolumn) this.dataview.sortfield = b.sortcolumn;
                    if (b.sortdirection) this.dataview.sortfielddirection = b.sortdirection;
                }
                if (this.filterable) if (this.columns) a.each(this.columns, function() {
                    if (this.filter) d.dataview.addfilter(this.datafield, this.filter);
                });
            }
            this._loading = true;
            this.dataview.update = function(b) {
                if (!d.pageable && d.virtualmode) d.loadondemand = true;
                d._loading = false;
                if (d.dataview.isupdating()) d.dataview.resumeupdate(false);
                if (d.pageable && d.pagerrenderer) if (d._initpager) d._initpager(); else throw new Error("jqxGrid: Missing reference to jqxgrid.pager.js.");
                if (d.source && d.source.sortcolumn && d.sortby && !d.virtualmode) {
                    d.render();
                    if (!d.source._source.sort) d.sortby(d.source.sortcolumn, d.source.sortdirection, d.source.sortcomparer);
                    d.source.sortcolumn = null;
                } else {
                    var e = d.vScrollInstance.value;
                    var f = d.hScrollInstance.value;
                    var g = d.source ? d.source.datatype : "array";
                    if ("local" != g || "array" != g) {
                        var h = null == d.virtualsizeinfo || null != d.virtualsizeinfo && 0 == d.virtualsizeinfo.virtualheight;
                        if ("cells" == c) {
                            var i = false;
                            if (d.filterable && d._initfilterpanel && d.dataview.filters.length) i = true;
                            if (false == b) {
                                if (!d.vScrollInstance.isScrolling() && !d.hScrollInstance.isScrolling()) {
                                    d._cellscache = new Array();
                                    d._pagescache = new Array();
                                    d._renderrows(d.virtualsizeinfo);
                                    if (d.showfilterrow && d.filterable && d.filterrow) d._updatelistfilters(true);
                                    if (d.showaggregates && d._updateaggregates) d._updateaggregates();
                                }
                                if (d.sortcolumn) d.sortby(d.sortcolumn, d.dataview.sortfielddirection, d.source.sortcomparer);
                                if (d.autoshowloadelement) {
                                    a(d.dataloadelement).css("visibility", "hidden");
                                    a(d.dataloadelement).css("display", "none");
                                }
                                if (d.virtualmode && !d._loading) {
                                    d.loadondemand = true;
                                    d._renderrows(d.virtualsizeinfo);
                                }
                                return;
                            } else if (i) c = "filter"; else if (void 0 != d.sortcolumn) c = "sort";
                        }
                        if (!d.virtualmode || h || d.virtualmode && d.pageable) if (true == d.initializedcall && "pagechanged" == c) {
                            e = 0;
                            if (d.groupable && d.groups.length > 0) {
                                d._render(true, true, false, false, false);
                                d._updatecolumnwidths();
                                d._updatecellwidths();
                                d._renderrows(d.virtualsizeinfo);
                            } else {
                                d.rendergridcontent(true);
                                if (d.pageable && d.updatepagerdetails) {
                                    d.updatepagerdetails();
                                    if (d.autoheight) {
                                        d._updatepageviews();
                                        if (d.autorowheight) d._renderrows(this.virtualsizeinfo);
                                    } else if (d.autorowheight) {
                                        d._updatepageviews();
                                        d._renderrows(this.virtualsizeinfo);
                                    }
                                }
                            }
                            if (d.showaggregates && d._updateaggregates) d._updateaggregates();
                        } else if ("filter" == c) if (d.virtualmode) {
                            d._render(true, true, false, false, false);
                            d._updatefocusedfilter();
                            d._updatecolumnwidths();
                            d._updatecellwidths();
                            d._renderrows(d.virtualsizeinfo);
                        } else d._render(true, true, false, false, false); else if ("sort" == c) {
                            if (d.virtualmode) {
                                d.rendergridcontent(true);
                                if (d.showaggregates && d._updateaggregates) d._updateaggregates();
                            } else {
                                d._render(true, true, false, false, false);
                                if (d.sortcolumn && !d.source.sort) d.sortby(d.sortcolumn, d.dataview.sortfielddirection, d.source.sortcomparer);
                            }
                            if (d.source.sort) d._updatefocusedfilter();
                        } else if ("data" == c) d._render(true, true, false, false, false); else if ("state" == c) d._render(true, true, false, d.menuitemsarray && d.menuitemsarray.length > 0 && !d.virtualmode); else d._render(true, true, true, d.menuitemsarray && d.menuitemsarray.length > 0 && !d.virtualmode); else if (d.virtualmode && true == b && !d.pageable) {
                            d._render(true, true, false, false, false);
                            d._updatefocusedfilter();
                            d._updatecolumnwidths();
                            d._updatecellwidths();
                            d._renderrows(d.virtualsizeinfo);
                        } else if (d.virtualmode && !d.pageable && false == b && void 0 != c) {
                            d.rendergridcontent(true);
                            if (d.showaggregates && d._updateaggregates) d._updateaggregates();
                        } else if (d.virtualmode && 0 == d.dataview.totalrecords && d.dataview.filters.length > 0) d._render(true, true, true, d.menuitemsarray && !d.virtualmode); else {
                            d._pagescache = new Array();
                            d._renderrows(d.virtualsizeinfo);
                        }
                        if (d.vScrollInstance.value != e && e <= d.vScrollInstance.max) d.vScrollInstance.setPosition(e);
                        if (d.hScrollInstance.value != f && f <= d.hScrollInstance.max) d.hScrollInstance.setPosition(f);
                    }
                }
                if (d.autoshowloadelement) {
                    a(d.dataloadelement).css("visibility", "hidden");
                    a(d.dataloadelement).css("display", "none");
                }
                if (d.pageable) {
                    if (d.pagerrightbutton) {
                        d.pagerrightbutton.jqxButton({
                            disabled: false
                        });
                        d.pagerleftbutton.jqxButton({
                            disabled: false
                        });
                        d.pagershowrowscombo.jqxDropDownList({
                            disabled: false
                        });
                    }
                    if (d.pagerfirstbutton) {
                        d.pagerfirstbutton.jqxButton({
                            disabled: false
                        });
                        d.pagerlastbutton.jqxButton({
                            disabled: false
                        });
                    }
                }
                d._raiseEvent(11);
                if (!d.initializedcall) {
                    var j = function() {
                        d._raiseEvent(0);
                        d.initializedcall = true;
                        d.isInitialized = true;
                        if (d.ready) d.ready();
                        if (d.renderstatusbar) d.renderstatusbar(d.statusbar);
                        if (d.rendertoolbar) d.rendertoolbar(d.toolbar);
                        if (d.autoloadstate) if (d.loadstate) d.loadstate(null, true);
                    };
                    if (!a.jqx.isHidden(d.host)) j(); else {
                        if (d.readyInterval) clearInterval(d.readyInterval);
                        d.readyInterval = setInterval(function() {
                            if (!a.jqx.isHidden(d.host)) if (d.__isRendered) {
                                clearInterval(d.readyInterval);
                                d.readyInterval = null;
                                j();
                                d._initmenu();
                            }
                        }, 200);
                    }
                    if (null != d.width && d.width.toString().indexOf("%") != -1 || null != d.height && d.height.toString().indexOf("%") != -1) ;
                    if ("hidden" == d.host.css("visibility")) {
                        var k = a.jqx.browser.msie && a.jqx.browser.version < 8;
                        if ("visible" == d.vScrollBar.css("visibility")) d.vScrollBar.css("visibility", "inherit");
                        if (!d.autowidth) if ("visible" == d.hScrollBar.css("visibility")) d.hScrollBar.css("visibility", "inherit");
                        d._intervalTimer = setInterval(function() {
                            if ("visible" == d.host.css("visibility")) {
                                d._updatesize(true);
                                clearInterval(d._intervalTimer);
                            }
                        }, 100);
                    }
                } else d._updateTouchScrolling();
            };
            this.dataview.databind(b);
            if (this.dataview.isupdating()) if (void 0 != e) this.dataview.suspend = false; else this.dataview.resumeupdate(false);
            this._initializeRows();
        },
        scrollto: function(a, b) {
            if (void 0 != a) this.hScrollInstance.setPosition(a);
            if (void 0 != b) this.vScrollInstance.setPosition(b);
        },
        scrollposition: function() {
            return {
                top: this.vScrollInstance.value,
                left: this.hScrollInstance.value
            };
        },
        ensurerowvisible: function(a) {
            if (this.autoheight && !this.pageable) return true;
            var b = this._getpagesize();
            var c = Math.floor(a / b);
            if (!this._pageviews[c] && !this.pageable) this._updatepageviews();
            if (this.groupable && this.groups.length > 0) return true;
            var d = false;
            if (this.pageable && this.gotopage && !this.virtualmode) {
                var c = Math.floor(a / b);
                if (this.dataview.pagenum != c) {
                    if (this.groupable && this.groups.length > 0) return true;
                    this.gotopage(c);
                    d = true;
                }
            }
            var e = this.vScrollInstance.value;
            var f = this._gettableheight() - this.rowsheight;
            var g = b * (a / b - c);
            g = Math.round(g);
            if (this._pageviews[c]) {
                var h = this._pageviews[c].top;
                var i = h + g * this.rowsheight;
                if (this.rowdetails) for (var j = b * c; j < a; j++) if (this.details[j]) if (false == this.details[j].rowdetailshidden) i += this.details[j].rowdetailsheight;
                if ("deferred" == this.scrollmode) if (this.vScrollInstance.max <= i + this.rowsheight) i = this.vScrollInstance.max;
                if (i < e) {
                    this.scrolltop(i);
                    d = true;
                } else if (i > e + f + 2) {
                    this.scrolltop(i - f);
                    d = true;
                }
            } else if (this.pageable) {
                var i = g * this.rowsheight;
                if (this.rowdetails) for (var j = b * c; j < b * c + g; j++) if (this.details[j] && false == this.details[j].rowdetailshidden) i += this.details[j].rowdetailsheight;
                if (i < e || i > e + f) {
                    this.scrollto(0, i);
                    d = true;
                }
            }
            return d;
        },
        ensurecellvisible: function(b, c) {
            var d = this.that;
            var e = this.hScrollBar.jqxScrollBar("value");
            var f = d.hScrollInstance.max;
            if (d.rtl) if ("visible" != this.hScrollBar.css("visibility")) f = 0;
            var g = this.ensurerowvisible(b);
            var h = 0;
            if (this.columns.records) {
                var i = e;
                if ("hidden" == this.hScrollBar.css("visibility")) return;
                var j = this.host.width();
                var k = 0;
                var l = "visible" == this.vScrollBar.css("visibility") ? 20 : 0;
                var m = false;
                a.each(this.columns.records, function() {
                    if (this.hidden) return true;
                    if (this.datafield == c) {
                        var a = 0;
                        var b = !d.rtl ? i : f - e;
                        if (h + this.width > b + j - l) {
                            a = h + this.width - j + l;
                            if (d.rtl) a = f - a;
                            d.scrollleft(a);
                            m = true;
                        } else if (h <= b) {
                            a = h - this.width;
                            if (d.rtl) a = f - a;
                            d.scrollleft(a);
                            m = true;
                        }
                        if (0 == k) {
                            if (d.rtl) d.scrollleft(f); else d.scrollleft(0);
                            m = true;
                        } else if (k == d.columns.records.length - 1) if ("visible" == d.hScrollBar.css("visibility")) {
                            if (!d.rtl) d.scrollleft(d.hScrollBar.jqxScrollBar("max")); else d.scrollleft(d.hScrollBar.jqxScrollBar("min"));
                            m = true;
                        }
                        return false;
                    }
                    k++;
                    h += this.width;
                });
                if (!m) d.scrollleft(i);
            }
            return g;
        },
        setrowheight: function(a, b) {
            if (this._loading) {
                throw new Error("jqxGrid: " + this.loadingerrormessage);
                return false;
            }
            if (null == a || null == b) return false;
            this.heightboundrows[a] = {
                index: a,
                height: b
            };
            a = this.getrowvisibleindex(a);
            if (a < 0) return false;
            if (this.rows.records[a]) this.rows.records[a].height = b; else {
                row = new c(this, null);
                row.height = b;
                this.rows.replace(a, row);
            }
            this.heights[a] = b;
            this.rendergridcontent(true);
            return true;
        },
        getrowheight: function(a) {
            if (null == a) return null;
            a = this.getrowvisibleindex(a);
            if (a < 0) return false;
            if (this.rows.records[a]) return this.rows.records[a].height;
        },
        setrowdetails: function(b, c, d, e) {
            if (void 0 == b || null == b || b < 0) return;
            var f = b + "_";
            if (this._rowdetailscache[f]) {
                var g = this._rowdetailscache[f].element;
                a(g).remove();
                this._rowdetailscache[f] = null;
            }
            var h = this.dataview.generatekey();
            this.detailboundrows[b] = {
                index: b,
                details: {
                    rowdetails: c,
                    rowdetailsheight: d,
                    rowdetailshidden: e,
                    key: h
                }
            };
            b = this.getrowvisibleindex(b);
            if (b < 0) return false;
            return this._setrowdetails(b, c, d, e, h);
        },
        getcolumn: function(b) {
            var c = null;
            if (this.columns.records) a.each(this.columns.records, function() {
                if (this.datafield == b || this.displayfield == b) {
                    c = this;
                    return false;
                }
            });
            return c;
        },
        _getcolumnindex: function(b) {
            var c = -1;
            if (this.columns.records) a.each(this.columns.records, function() {
                c++;
                if (this.datafield == b) return false;
            });
            return c;
        },
        _getcolumnat: function(a) {
            var b = this.columns.records[a];
            return b;
        },
        _getprevvisiblecolumn: function(a) {
            var b = this.that;
            while (a > 0) {
                a--;
                var c = b.getcolumnat(a);
                if (!c) return null;
                if (!c.hidden) return c;
            }
            return null;
        },
        _getnextvisiblecolumn: function(a) {
            var b = this.that;
            while (a < this.columns.records.length) {
                a++;
                var c = b.getcolumnat(a);
                if (!c) return null;
                if (!c.hidden) return c;
            }
            return null;
        },
        getcolumnat: function(a) {
            if (!isNaN(a)) {
                var b = this.columns.records[a];
                return b;
            }
            return null;
        },
        _getcolumn: function(b) {
            var c = null;
            a.each(this._columns, function() {
                if (this.datafield == b || this.displayfield == b) {
                    c = this;
                    return false;
                }
            });
            return c;
        },
        _setcolumnproperty: function(a, b, c) {
            if (null == a || null == b || null == c) return null;
            b = b.toLowerCase();
            var d = this.getcolumn(a);
            if (null == d) return;
            var e = d[b];
            d[b] = c;
            var f = this._getcolumn(a);
            if (null != f) f[b] = c;
            this._cellscache = new Array();
            switch (b) {
                case "filteritems":
                    if (this.filterable && this.showfilterrow) this._updatelistfilters(true, true);
                    break;

                case "text":
                    this.prerenderrequired = true;
                    this._rendercolumnheaders();
                    this._updatecellwidths();
                    if (this._groupsheader()) if (this._initgroupsheader) this._initgroupsheader();
                    this._renderrows(this.virtualsizeinfo);
                    break;

                case "editable":
                case "resizable":
                case "draggable":
                    if ("editable" == b) if (c != e) {
                        if (null != this.editcell && this.endcelledit) this.endcelledit(this.editcell.row, this.editcell.column, true, true);
                        if ("checkbox" == d.columntype) {
                            this.prerenderrequired = true;
                            this.rendergridcontent(true, false);
                            if (this.updating()) return false;
                        }
                        if (this.updating()) return false;
                        this._renderrows(this.virtualsizeinfo);
                    }
                    break;

                case "hidden":
                case "hideable":
                case "renderer":
                case "cellsrenderer":
                case "align":
                case "aggregates":
                case "cellsalign":
                case "cellsformat":
                case "pinned":
                case "contenttype":
                case "filterable":
                case "groupable":
                case "cellclass":
                case "cellclassname":
                case "classname":
                case "class":
                    this.prerenderrequired = true;
                    if ("pinned" == b) {
                        this._initializeColumns();
                        this._preparecolumngroups();
                    }
                    this.rendergridcontent(true);
                    if (this.updating()) return false;
                    if ("hidden" == b) {
                        this._updatecolumnwidths();
                        this._updatecellwidths();
                    }
                    this._renderrows(this.virtualsizeinfo);
                    if (this.showaggregates && this._updateaggregates) this._updateaggregates();
                    break;

                case "width":
                case "minwidth":
                case "maxwidth":
                    if (this.updating()) return false;
                    d._width = null;
                    d._percentagewidth = null;
                    this._updatecolumnwidths();
                    this._updatecellwidths();
                    this._renderrows(this.virtualsizeinfo);
            }
        },
        _getcolumnproperty: function(a, b) {
            if (null == a || null == b) return null;
            b = b.toLowerCase();
            var c = this.getcolumn(a);
            return c[b];
        },
        setcolumnproperty: function(a, b, c) {
            this._setcolumnproperty(a, b, c);
        },
        getcolumnproperty: function(a, b) {
            return this._getcolumnproperty(a, b);
        },
        hidecolumn: function(a) {
            this._setcolumnproperty(a, "hidden", true);
        },
        showcolumn: function(a) {
            this._setcolumnproperty(a, "hidden", false);
        },
        iscolumnvisible: function(a) {
            return !this._getcolumnproperty(a, "hidden");
        },
        pincolumn: function(a) {
            this._setcolumnproperty(a, "pinned", true);
        },
        unpincolumn: function(a) {
            this._setcolumnproperty(a, "pinned", false);
        },
        iscolumnpinned: function(a) {
            return this._getcolumnproperty(a, "pinned");
        },
        _setrowdetails: function(a, b, c, d, e) {
            if (0 == c) c = 100;
            if (null == a || null == c) return false;
            if (null != e) this.details[a] = {
                rowdetails: b,
                rowdetailsheight: c,
                rowdetailshidden: d,
                detailskey: e
            }; else {
                var f = null != this.details[a] ? this.details[a].detailskey : null;
                var g = {
                    rowdetails: b,
                    rowdetailsheight: c,
                    rowdetailshidden: d,
                    detailskey: f
                };
                var h = this.that;
                for (var i = 0; i < this.detailboundrows.length; i++) if (void 0 != this.detailboundrows[i]) {
                    var j = this.detailboundrows[i];
                    if (j.details.detailskey == f) {
                        j.details.rowdetailsheight = g.rowdetailsheight;
                        j.details.rowdetailshidden = g.rowdetailshidden;
                        j.details.rowdetails = g.rowdetails;
                        break;
                    }
                }
                this.details[a] = g;
            }
            this.rendergridcontent(true);
            this._updatecolumnwidths();
            this._updatecellwidths();
            this._renderrows(this.virtualsizeinfo);
            return true;
        },
        getrowdetails: function(a) {
            if (null == a) return false;
            a = this.getrowvisibleindex(a);
            return this._getrowdetails(a);
        },
        _getrowdetails: function(a) {
            if (null == a) return false;
            if (a < 0) return false;
            if (this.details[a]) return this.details[a];
            if (this.rowdetailstemplate) return this.rowdetailstemplate;
        },
        getrecordscount: function() {
            return this.dataview.totalrecords;
        },
        showrowdetails: function(a) {
            if (this._loading) {
                throw new Error("jqxGrid: " + this.loadingerrormessage);
                return false;
            }
            if (null == a) return false;
            a = this.getrowvisibleindex(a);
            if (a < 0) return false;
            var b = this._getrowdetails(a);
            return this._setrowdetailsvisibility(a, b, false);
        },
        hiderowdetails: function(a) {
            if (this._loading) {
                throw new Error("jqxGrid: " + this.loadingerrormessage);
                return false;
            }
            a = this.getrowvisibleindex(a);
            if (a < 0) return false;
            var b = this._getrowdetails(a);
            return this._setrowdetailsvisibility(a, b, true);
        },
        _togglerowdetails: function(a) {
            var b = a.visibleindex;
            var c = this._getrowdetails(b);
            if (null != c) {
                var d = this.vScrollInstance.value;
                var e = !c.rowdetailshidden;
                var f = this._setrowdetailsvisibility(b, c, e);
                if (0 !== d && "hidden" !== this.vScrollBar.css("visibility")) if (d <= this.vScrollInstance.max) this.vScrollInstance.setPosition(d); else this.vScrollInstance.setPosition(this.vScrollInstance.max);
                return f;
            }
            return false;
        },
        _setrowdetailsvisibility: function(a, b, c) {
            if (this.rowdetailstemplate) {
                if (!this.details) this.details = new Array();
                if (!this.details[a]) {
                    this.details[a] = {
                        rowdetailshidden: this.rowdetailstemplate.rowdetailshidden,
                        rowdetailsheight: this.rowdetailstemplate.rowdetailsheight,
                        rowdetails: this.rowdetailstemplate.rowdetails
                    };
                    var d = this.dataview.generatekey();
                    this.details[a].detailskey = d;
                    this.detailboundrows[a] = {
                        index: a,
                        details: this.details[a]
                    };
                }
            }
            if (null != b) this.details[a].rowdetailshidden = c; else return false;
            var e = this.details[a];
            if (c) this._raiseEvent(21, {
                rowindex: a,
                details: e.rowdetails,
                height: e.rowdetailsheight
            }); else this._raiseEvent(20, {
                rowindex: a,
                details: e.rowdetails,
                height: e.rowdetailsheight
            });
            return this._setrowdetails(a, e.rowdetails, e.rowdetailsheight, e.rowdetailshidden);
        },
        getrowvisibleindex: function(a) {
            if (void 0 == a || null == a || a < 0) return false;
            if (this.virtualmode) {
                var b = this.dataview.loadedrecords[a];
                if (void 0 == b) return -1;
                return b.visibleindex;
            }
            return this.getrowdisplayindex(a);
        },
        hiderow: function(a) {
            if (this._loading) {
                throw new Error("jqxGrid: " + this.loadingerrormessage);
                return false;
            }
            if (void 0 == a || null == a || a < 0) return false;
            if (null == a) return false;
            this.hiddenboundrows[a] = {
                index: a,
                hidden: true
            };
            a = this.getrowvisibleindex(a);
            return this._setrowvisibility(a, true);
        },
        showrow: function(a) {
            if (this._loading) {
                throw new Error("jqxGrid: " + this.loadingerrormessage);
                return false;
            }
            if (void 0 == a || null == a || a < 0) return false;
            if (null == a) return false;
            this.hiddenboundrows[a] = {
                index: a,
                hidden: false
            };
            a = this.getrowvisibleindex(a);
            return this._setrowvisibility(a, false);
        },
        isrowhiddenat: function(a) {
            if (null == a) return null;
            a = this.getrowvisibleindex(a);
            if (this.rows.records[a]) return this.rows.records[a].hidden;
        },
        _setrowvisibility: function(a, b, c) {
            if (null == a) return false;
            this.hiddens[a] = b;
            if (void 0 == c || c) {
                this.rendergridcontent(true);
                return true;
            }
            return false;
        },
        _loadrows: function() {
            if (!this._pageviews[this.dataview.pagenum] && !this.pageable) return;
            var a = !this.pageable ? this._pageviews[this.dataview.pagenum].top : 0;
            if (!this.pageable && void 0 != this._pagescache[this.dataview.pagenum]) return null;
            if (!this.virtualsizeinfo) return;
            var b = this.that;
            var d = new Array();
            var e = new Array();
            var f = b.groupable && b.groups.length > 0;
            var g = this.dataview.totalrecords;
            var h = this.virtualsizeinfo.virtualheight;
            var i = 0;
            this.rows.beginupdate();
            var j = this.dataview.pagesize;
            if (this.pageable && f) j = this.dataview.rows.length;
            for (var k = 0; k < j; k++) {
                if (k >= this.dataview.rows.length) break;
                var l = this.dataview.rows[k];
                var m = null;
                if (!b.rows.records[l.visibleindex]) m = new c(b, l); else {
                    m = b.rows.records[l.visibleindex];
                    m.setdata(l);
                }
                m.hidden = this.hiddens[m.visibleindex];
                if (this.rowdetailstemplate) {
                    m.rowdetails = this.rowdetailstemplate.rowdetails;
                    m.rowdetailsheight = this.rowdetailstemplate.rowdetailsheight;
                    m.rowdetailshidden = this.rowdetailstemplate.rowdetailshidden;
                }
                var n = this.details[m.visibleindex];
                if (n) {
                    m.rowdetails = n.rowdetails;
                    m.rowdetailsheight = n.rowdetailsheight;
                    m.rowdetailshidden = n.rowdetailshidden;
                } else if (!this.rowdetailstemplate) m.rowdetails = null;
                if (f && this.pageable && null != m.parentbounddata) {
                    var o = d[m.parentbounddata.uniqueid];
                    if (null != o) {
                        var p = this._findgroupstate(o.uniqueid);
                        if (this._setsubgroupsvisibility) this._setsubgroupsvisibility(this, m.parentbounddata, !p, false);
                        m.hidden = this.hiddens[m.visibleindex];
                    }
                    if (null != o && void 0 != o) {
                        m.parentrow = o;
                        o.subrows[o.subrows.length++] = m;
                    }
                }
                if (m.hidden) continue;
                var q = l.visibleindex;
                if (!this.heights[q]) this.heights[q] = this.rowsheight;
                m.height = this.heights[q];
                if (this.rowdetails) if (m.rowdetails && !m.rowdetailshidden) m.height += m.rowdetailsheight;
                d[m.uniqueid] = m;
                e[i++] = m;
                m.top = a;
                a += m.height;
                var r = q;
                b.rows.replace(r, m);
            }
            if ((this.autoheight || this.pageable) && this.autorowheight) if (this._pageviews && this._pageviews.length > 0) this._pageviews[0].height = a;
            this.rows.resumeupdate();
            if (e.length > 0) this._pagescache[this.dataview.pagenum] = e;
        },
        _gettableheight: function() {
            if (void 0 != this.tableheight) return this.tableheight;
            var a = this.host.height();
            if (this.columnsheader) {
                var b = this.columnsheader.outerHeight();
                if (!this.showheader) b = 0;
            }
            a -= b;
            if ("visible" == this.hScrollBar[0].style.visibility) a -= this.hScrollBar.outerHeight();
            if (this.pageable) a -= this.pager.outerHeight();
            if (this._groupsheader()) a -= this.groupsheader.outerHeight();
            if (this.showtoolbar) a -= this.toolbarheight;
            if (this.showstatusbar) a -= this.statusbarheight;
            if (a > 0) {
                this.tableheight = a;
                return a;
            }
            return this.host.height();
        },
        _getpagesize: function() {
            if (this.pageable) return this.pagesize;
            if (this.virtualmode) {
                var a = Math.round(this.host.height()) + 2 * this.rowsheight;
                var b = Math.round(a / this.rowsheight);
                return b;
            }
            if (this.autoheight || this.autorowheight) {
                if (0 == this.dataview.totalrows) return 1;
                return this.dataview.totalrows;
            }
            if (this.dataview.totalrows < 100 && this.dataview.totalrecords < 100 && this.dataview.totalrows > 0) return this.dataview.totalrows;
            return 100;
        },
        _calculatevirtualheight: function() {
            var a = this.that;
            var b = Math.round(this.host.height()) + 2 * this.rowsheight;
            realheight = this._gettableheight();
            var c = Math.round(b / this.rowsheight);
            this.heights = new Array();
            this.hiddens = new Array();
            this.details = new Array();
            this.expandedgroups = new Array();
            this.hiddenboundrows = new Array();
            this.heightboundrows = new Array();
            this.detailboundrows = new Array();
            var d = Math.max(this.dataview.totalrows, this.dataview.totalrecords);
            if (this.pageable) {
                d = this.pagesize;
                if (this.pagesize > Math.max(this.dataview.totalrows, this.dataview.totalrecords) && this.autoheight) d = Math.max(this.dataview.totalrows, this.dataview.totalrecords); else if (!this.autoheight) if (this.dataview.totalrows < this.pagesize) d = Math.max(this.dataview.totalrows, this.dataview.totalrecords);
            }
            var e = d * this.rowsheight;
            var f = 0;
            var g = 0;
            var h = 0;
            var i = this._getpagesize();
            var j = i * this.rowsheight;
            var k = 0;
            if (!this.pageable && this.autoheight) c = d;
            if (d + i > 0) while (k <= d + i) {
                f += j;
                if (k - i < d && k >= d) {
                    var l = k - d;
                    if (l > 0) {
                        h -= j;
                        this._pageviews[g - 1] = {
                            top: h,
                            height: j - l * this.rowsheight
                        };
                    }
                    break;
                } else this._pageviews[g++] = {
                    top: h,
                    height: j
                };
                h = f;
                k += i;
            }
            if (true != this.resizingGrid) this.vScrollBar.jqxScrollBar({
                value: 0
            });
            if (e > realheight && !this.autoheight) {
                this.vScrollBar.css("visibility", "visible");
                if ("deferred" == this.scrollmode) this.vScrollBar.jqxScrollBar({
                    max: e
                }); else this.vScrollBar.jqxScrollBar({
                    max: e - realheight
                });
            } else this.vScrollBar.css("visibility", "hidden");
            this.dataview.pagesize = i;
            this.dataview.updateview();
            return {
                visiblerecords: c,
                virtualheight: e
            };
        },
        _updatepageviews: function() {
            if (this.updating()) return;
            this._pagescache = new Array();
            this._pageviews = new Array();
            this.tableheight = null;
            var a = this.that;
            var b = Math.round(this.host.height()) + 2 * this.rowsheight;
            var c = Math.round(b / this.rowsheight);
            var d = Math.max(this.dataview.totalrows, this.dataview.totalrecords);
            var e = d * this.rowsheight;
            var f = 0;
            var g = 0;
            var h = 0;
            var i = 0;
            var j = 0;
            var k = this._getpagesize();
            if (!this.pageable) for (var l = 0; l < d; l++) {
                var m = {
                    index: l,
                    height: this.heights[l],
                    hidden: this.hiddens[l],
                    details: this.details[l]
                };
                if (void 0 == this.heights[l]) {
                    this.heights[l] = this.rowsheight;
                    m.height = this.rowsheight;
                }
                if (void 0 == this.hiddens[l]) {
                    this.hiddens[l] = false;
                    m.hidden = false;
                }
                if (void 0 == this.details[l]) this.details[l] = null;
                if (m.height != a.rowsheight) {
                    e -= a.rowsheight;
                    e += m.height;
                }
                if (m.hidden) e -= m.height; else {
                    g += m.height;
                    var n = 0;
                    if (this.rowdetails) {
                        if (this.rowdetailstemplate) if (!m.details) m.details = this.rowdetailstemplate;
                        if (m.details && m.details.rowdetails && !m.details.rowdetailshidden) {
                            n = m.details.rowdetailsheight;
                            g += n;
                            e += n;
                        }
                    }
                    f += m.height + n;
                }
                j++;
                if (j >= k || l == d - 1) {
                    this._pageviews[h++] = {
                        top: i,
                        height: g
                    };
                    g = 0;
                    i = f;
                    j = 0;
                }
            } else {
                if (this._updatepagedview) e = this._updatepagedview(d, e, 0);
                if (this.autoheight) this._arrange();
            }
            var o = this._gettableheight();
            if (e > o) {
                if (this.pageable && this.gotopage) {
                    e = this._pageviews[0].height;
                    if (e < 0) e = this._pageviews[0].height;
                }
                if ("visible" != this.vScrollBar.css("visibility")) this.vScrollBar.css("visibility", "visible");
                if (e <= o || this.autoheight) this.vScrollBar.css("visibility", "hidden");
                if (e - o > 0) if ("deferred" != this.scrollmode) {
                    var p = e - o;
                    var q = this.vScrollInstance.max;
                    this.vScrollBar.jqxScrollBar({
                        max: p
                    });
                    if (p != q) this.vScrollBar.jqxScrollBar({
                        value: 0
                    });
                } else this.vScrollBar.jqxScrollBar({
                    value: 0,
                    max: e
                }); else this.vScrollBar.jqxScrollBar({
                    value: 0,
                    max: e
                });
            } else {
                if (!this._loading) this.vScrollBar.css("visibility", "hidden");
                this.vScrollBar.jqxScrollBar({
                    value: 0
                });
            }
            this._arrange();
            if (this.autoheight) c = Math.round(this.host.height() / this.rowsheight);
            this.virtualsizeinfo = {
                visiblerecords: c,
                virtualheight: e
            };
        },
        updatebounddata: function(a) {
            if ("data" != a && "sort" != a && "filter" != a && "cells" != a && "pagechanged" != a && "pagesizechanged" != a && !this.virtualmode) {
                this.virtualsizeinfo = null;
                if (this.showfilterrow && this.filterable && this.filterrow) {
                    if (this.clearfilters) this.clearfilters(false);
                    this.filterrow.remove();
                    this._filterrowcache = new Array();
                    this.filterrow = null;
                } else if (this.filterable) if (this.clearfilters) this.clearfilters(false);
                if (this.groupable) {
                    this.dataview.groups = [];
                    this.groups = [];
                }
                if (this.pageable) {
                    this.pagenum = 0;
                    this.dataview.pagenum = 0;
                }
                if (this.sortable) {
                    this.sortcolumn = null;
                    this.sortdirection = "";
                    this.dataview.sortfielddirection = "";
                    this.dataview.clearsortdata();
                }
            }
            this.databind(this.source, a);
        },
        refreshdata: function() {
            this._refreshdataview();
            this.render();
        },
        _updatevscrollbarmax: function() {
            if (this._pageviews && this._pageviews.length > 0) {
                var a = this._pageviews[0].height;
                if (this.virtualmode || !this.pageable) a = this.virtualsizeinfo.virtualheight;
                var b = this._gettableheight();
                if (a > b) {
                    if (this.pageable && this.gotopage) {
                        a = this._pageviews[0].height;
                        if (a < 0) a = this._pageviews[0].height;
                    }
                    if ("visible" != this.vScrollBar.css("visibility")) this.vScrollBar.css("visibility", "visible");
                    if (a <= b || this.autoheight) this.vScrollBar.css("visibility", "hidden");
                    if (a - b > 0) {
                        var c = a - b;
                        this.vScrollBar.jqxScrollBar({
                            max: c
                        });
                    } else this.vScrollBar.jqxScrollBar({
                        value: 0,
                        max: a
                    });
                } else {
                    this.vScrollBar.css("visibility", "hidden");
                    this.vScrollBar.jqxScrollBar({
                        value: 0
                    });
                }
            }
        },
        _refreshdataview: function() {
            this.dataview.refresh();
        },
        refresh: function(b) {
            if (true != b) {
                if (a.jqx.isHidden(this.host)) return;
                if (null != this.virtualsizeinfo) {
                    this._cellscache = new Array();
                    this._renderrows(this.virtualsizeinfo);
                    this._updatesize();
                }
            }
        },
        render: function() {
            this._render(true, true, true, true);
        },
        invalidate: function() {
            if (this.virtualsizeinfo) {
                this._updatecolumnwidths();
                this._updatecellwidths();
                this._renderrows(this.virtualsizeinfo);
            }
        },
        clear: function() {
            this.databind(null);
            this.render();
        },
        _preparecolumngroups: function() {
            var a = this.columnsheight;
            if (this.columngroups) {
                this.columnshierarchy = new Array();
                if (this.columngroups.length) {
                    var b = this;
                    for (var c = 0; c < this.columngroups.length; c++) {
                        this.columngroups[c].parent = null;
                        this.columngroups[c].groups = null;
                    }
                    for (var c = 0; c < this.columns.records.length; c++) {
                        this.columns.records[c].parent = null;
                        this.columns.records[c].groups = null;
                    }
                    var d = function(a) {
                        for (var c = 0; c < b.columngroups.length; c++) {
                            var d = b.columngroups[c];
                            if (d.name === a) return d;
                        }
                        return null;
                    };
                    for (var c = 0; c < this.columngroups.length; c++) {
                        var e = this.columngroups[c];
                        if (!e.groups) e.groups = null;
                        if (e.parentgroup) {
                            var f = d(e.parentgroup);
                            if (f) {
                                e.parent = f;
                                if (!f.groups) f.groups = new Array();
                                if (f.groups.indexOf(e) === -1) f.groups.push(e);
                            }
                        }
                    }
                    for (var c = 0; c < this.columns.records.length; c++) {
                        var e = this.columns.records[c];
                        if (e.columngroup) {
                            var f = d(e.columngroup);
                            if (f) {
                                if (!f.groups) f.groups = new Array();
                                e.parent = f;
                                if (f.groups.indexOf(e) === -1) f.groups.push(e);
                            }
                        }
                    }
                    var g = 0;
                    for (var c = 0; c < this.columns.records.length; c++) {
                        var e = this.columns.records[c];
                        var h = e;
                        e.level = 0;
                        while (h.parent) {
                            h = h.parent;
                            e.level++;
                        }
                        var h = e;
                        var i = e.level;
                        g = Math.max(g, e.level);
                        while (h.parent) {
                            h = h.parent;
                            if (h) h.level = --i;
                        }
                    }
                    var j = function(a) {
                        var b = new Array();
                        if (a.columngroup) b.push(a);
                        if (a.groups) for (var c = 0; c < a.groups.length; c++) if (a.groups[c].columngroup) b.push(a.groups[c]); else if (a.groups[c].groups) {
                            var d = j(a.groups[c]);
                            for (var e = 0; e < d.length; e++) b.push(d[e]);
                        }
                        return b;
                    };
                    for (var c = 0; c < this.columngroups.length; c++) {
                        var e = this.columngroups[c];
                        var k = j(e);
                        e.columns = k;
                        var l = new Array();
                        var m = 0;
                        for (var n = 0; n < k.length; n++) {
                            l.push(this.columns.records.indexOf(k[n]));
                            if (k[n].pinned) m++;
                        }
                        if (0 != m) throw new Error("jqxGrid: Column Groups initialization Error. Please, check the initialization of the jqxGrid's columns array. The columns in a column group cannot be pinned.");
                        l.sort(function(a, b) {
                            a = parseInt(a);
                            b = parseInt(b);
                            if (a < b) return -1;
                            if (a > b) return 1;
                            return 0;
                        });
                        for (var o = 1; o < l.length; o++) if (l[o] != l[o - 1] + 1) {
                            throw new Error("jqxGrid: Column Groups initialization Error. Please, check the initialization of the jqxGrid's columns array. The columns in a column group are expected to be siblings in the columns array.");
                            this.host.remove();
                        }
                    }
                }
                this.columngroupslevel = 1 + g;
                a = this.columngroupslevel * this.columnsheight;
            }
            return a;
        },
        _render: function(b, c, d, e, f) {
            if (null == this.dataview) return;
            if (this._loading) return;
            if (this._batchupdate) return;
            if (a.jqx.isHidden(this.host)) {
                var g = this;
                if (g.___hiddenTimer) {
                    clearInterval(g.___hiddenTimer);
                    g.___hiddenTimer = null;
                }
                this.___hiddenTimer = setInterval(function() {
                    if (!a.jqx.isHidden(g.host)) {
                        clearInterval(g.___hiddenTimer);
                        g.render();
                    }
                }, 300);
                return;
            }
            if (null != this.editcell && this.endcelledit) this.endcelledit(this.editcell.row, this.editcell.column, true, false);
            this.validationpopup = null;
            this._removeHandlers();
            this._addHandlers();
            this._initializeRows();
            this._requiresupdate = void 0 != c ? c : true;
            this._newmax = null;
            if (d) {
                if (!this._requiresupdate) if (false != e) this._initmenu();
                if (null == this.columns) this.columns = new a.jqx.collection(this.element); else {
                    var h = this;
                    if (this.columns && "observableArray" === this.columns.name) this.columns.notifier = function(a) {
                        var b = function() {
                            h.columns = h._columns;
                            h.render();
                        };
                        switch (a.type) {
                            case "add":
                                b();
                                break;

                            case "update":
                                if ("index" === a.name) {
                                    h.beginupdate();
                                    for (var c in a.newValue) h.setcolumnproperty(a.newValue.datafield, c, a.newValue[c]);
                                    h.endupdate();
                                } else {
                                    var d = a.path.split(".");
                                    h.setcolumnproperty(h.columns[d[0]].datafield, a.name, a.newValue);
                                }
                                break;

                            case "delete":
                                b();
                        }
                    };
                    if (this.columngroups && "observableArray" === this.columngroups.name) this.columngroups.notifier = function(a) {
                        h.render();
                    };
                    this._initializeColumns();
                }
            }
            this.tableheight = null;
            this._pagescache = new Array();
            this._pageviews = new Array();
            this.visiblerows = new Array();
            this.hittestinfo = new Array();
            if (this._requiresupdate) {
                this._clearcaches();
                if (true == e) this._initmenu();
            }
            this.virtualsizeinfo = null;
            this.prerenderrequired = true;
            if (this.groupable && this.groups.length > 0 && this.rowdetails || this.rowdetails) if (this.gridcontent) {
                this._rowdetailscache = new Array();
                this._rowdetailselementscache = new Array();
                this.detailboundrows = new Array();
                this.details = new Array();
                a.jqx.utilities.html(this.gridcontent, "");
                this.gridcontent = null;
            }
            if (this.gridcontent) if (this.editable && this._destroyeditors) this._destroyeditors();
            if (d) {
                if (this.filterrow) this.filterrow.detach();
                a.jqx.utilities.html(this.content, "");
                this.columnsheader = this.columnsheader || a('<div style="overflow: hidden;"></div>');
                this.columnsheader.remove();
                this.columnsheader.addClass(this.toTP("jqx-widget-header"));
                this.columnsheader.addClass(this.toTP("jqx-grid-header"));
            } else if (this.gridcontent) a.jqx.utilities.html(this.gridcontent, "");
            if (!this.showheader) this.columnsheader.css("display", "none"); else if (this.columnsheader) this.columnsheader.css("display", "block");
            this.gridcontent = this.gridcontent || a('<div style="width: 100%; overflow: hidden; position: absolute;"></div>');
            this.gridcontent.remove();
            var i = this.columnsheight;
            i = this._preparecolumngroups();
            if (this.showfilterrow && this.filterable) this.columnsheader.height(i + this.filterrowheight); else this.columnsheader.height(i);
            this.content.append(this.columnsheader);
            this.content.append(this.gridcontent);
            this._arrange();
            if (this._initgroupsheader) this._initgroupsheader();
            this.selectionarea = this.selectionarea || a("<div style='z-index: 99999; visibility: hidden; position: absolute;'></div>");
            this.selectionarea.addClass(this.toThemeProperty("jqx-grid-selectionarea"));
            this.selectionarea.addClass(this.toThemeProperty("jqx-fill-state-pressed"));
            this.content.append(this.selectionarea);
            this.tableheight = null;
            this.rendergridcontent(false, d);
            if (this.groups.length > 0 && this.groupable) {
                var j = this.vScrollBar[0].style.visibility;
                this.suspendgroupevents = true;
                if (this.collapseallgroups) if (!this.groupsexpandedbydefault) {
                    this.collapseallgroups(false);
                    this._updatescrollbarsafterrowsprerender();
                } else this.expandallgroups(false);
                if (this.vScrollBar[0].style.visibility != j) {
                    this._updatecolumnwidths();
                    this._updatecellwidths();
                }
                this.suspendgroupevents = false;
            }
            if (this.pageable && this.updatepagerdetails) {
                this.updatepagerdetails();
                if (this.autoheight) this._updatepageviews();
                if (this.autorowheight) {
                    if (!this.autoheight) this._updatepageviews();
                    this._renderrows(this.virtualsizeinfo);
                }
            }
            if (this.showaggregates && this._updateaggregates) this._updateaggregates();
            this._addoverlayelement();
            if ("deferred" == this.scrollmode) this._addscrollelement();
            if (this.showfilterrow && this.filterable && this.filterrow && (void 0 == f || true == f)) this._updatelistfilters(!d);
            if (this.rendered) this.rendered("full");
            this.__isRendered = true;
        },
        _addoverlayelement: function() {
            if (this.autoheight) {
                if (this._overlayElement) this._overlayElement.remove();
                this._updateTouchScrolling();
                return;
            }
            var b = a.jqx.utilities.getBrowser();
            if ("msie" == b.browser && parseInt(b.version) < 9 || this.isTouchDevice()) {
                if (this._overlayElement) this._overlayElement.remove();
                this._overlayElement = a("<div style='visibility: hidden; position: absolute; width: 100%; height: 100%;'></div>");
                this._overlayElement.css("background", "white");
                this._overlayElement.css("z-index", 18e3);
                this._overlayElement.css("opacity", .001);
                if (this.isTouchDevice()) {
                    if ("hidden" !== this.vScrollBar.css("visibility") || "hidden" !== this.hScrollBar.css("visibility")) {
                        var c = 0;
                        if ("checkbox" == this.selectionmode) c += 30;
                        if (this.groupable || this.rowdetails) this._overlayElement.css("left", 30 * (this.groups.length + (this.rowdetails ? 1 : 0)));
                        var d = this._overlayElement.css("left");
                        this._overlayElement.css("left", d + c);
                    } else if (this._overlayElement) this._overlayElement.remove();
                } else this.content.prepend(this._overlayElement);
            }
            this._updateTouchScrolling();
        },
        _addscrollelement: function() {
            if (this._scrollelement) this._scrollelement.remove();
            if (this._scrollelementoverlay) this._scrollelementoverlay.remove();
            this._scrollelementoverlay = a("<div style='visibility: hidden; position: absolute; width: 100%; height: 100%;'></div>");
            this._scrollelementoverlay.css("background", "black");
            this._scrollelementoverlay.css("z-index", 18e3);
            this._scrollelementoverlay.css("opacity", .1);
            this._scrollelement = a("<span style='visibility: hidden; top: 50%; right: 10px; position: absolute;'></span>");
            this._scrollelement.css("z-index", 18005);
            this._scrollelement.addClass(this.toThemeProperty("jqx-button"));
            this._scrollelement.addClass(this.toThemeProperty("jqx-fill-state-normal"));
            this._scrollelement.addClass(this.toThemeProperty("jqx-rc-all"));
            this._scrollelement.addClass(this.toThemeProperty("jqx-shadow"));
            this.content.prepend(this._scrollelement);
            this.content.prepend(this._scrollelementoverlay);
        },
        rendergridcontent: function(a, b) {
            if (this.updating()) return false;
            if (void 0 == a || null == a) a = false;
            this._requiresupdate = a;
            var c = this.prerenderrequired;
            if (this.prerenderrequired) this._arrange();
            var d = this.that;
            var b = b;
            if (null == b || void 0 == b) b = true;
            this.tableheight = null;
            d.virtualsizeinfo = d.virtualsizeinfo || d._calculatevirtualheight();
            if (d.pageable && !d.autoheight) if (d.dataview.totalrows < d.pagesize) d._requiresupdate = true;
            if (b) d._rendercolumnheaders(); else {
                if (this._rendersortcolumn) this._rendersortcolumn();
                if (this._renderfiltercolumn) this._renderfiltercolumn();
            }
            d._renderrows(d.virtualsizeinfo);
            if (this.gridcontent) {
                if (0 != this.gridcontent[0].scrollTop) this.gridcontent[0].scrollTop = 0;
                if (0 != this.gridcontent[0].scrollLeft) this.gridcontent[0].scrollLeft = 0;
            }
            if (c) {
                var e = this.tableheight;
                this._arrange();
                if (e != this.tableheight && this.autoheight) d._renderrows(d.virtualsizeinfo);
            }
            if (this.rtl) this._renderhorizontalscroll();
            if (this.autosavestate) if (null != this.initializedcall) if (this.savestate) this.savestate();
            return true;
        },
        _updatecolumnwidths: function() {
            var b = this.host.width();
            var c = b;
            var d = "";
            if (void 0 == this.columns || void 0 == this.columns.records) return;
            var e = this.that;
            var f = this.rowdetails && this.showrowdetailscolumn ? (1 + this.groups.length) * this.groupindentwidth : this.groups.length * this.groupindentwidth;
            a.each(this.columns.records, function(a, g) {
                if (!(this.hidden && this.hideable)) if (this.width.toString().indexOf("%") != -1 || void 0 != this._percentagewidth) {
                    var g = 0;
                    var h = "hidden" == e.vScrollBar[0].style.visibility ? 0 : e.scrollbarsize + 5;
                    if (e.scrollbarautoshow) h = 0;
                    var i = c;
                    g = parseFloat(this.width) * i / 100;
                    h += f;
                    if (void 0 != this._percentagewidth) g = parseFloat(this._percentagewidth) * (i - h) / 100;
                    if (g < this.minwidth && "auto" != this.minwidth) g = this.minwidth;
                    if (g > this.maxwidth && "auto" != this.maxwidth) g = this.maxwidth;
                    b -= g;
                } else if ("auto" != this.width && !this._width) b -= this.width; else d += this.text;
            });
            var g = this._gettableheight();
            if (!this.autoheight) if (this.virtualsizeinfo && this.virtualsizeinfo.virtualheight > g) if (this.groupable && this.groups.length > 0) if (this.dataview && this.dataview.loadedrootgroups && !this.groupsexpandedbydefault) {
                var h = this.dataview.loadedrootgroups.length * this.rowsheight;
                if (this.pageable) for (var i = 0; i < this.dataview.rows.length; i++) if (this.dataview.rows[i].group && 0 === this.dataview.rows[i].level) h += this.rowsheight;
                if (h > g) {
                    b -= this.scrollbarsize + 5;
                    c -= this.scrollbarsize + 5;
                } else if ("visible" == this.vScrollBar.css("visibility")) {
                    b -= this.scrollbarsize + 5;
                    c -= this.scrollbarsize + 5;
                }
            } else {
                b -= this.scrollbarsize + 5;
                c -= this.scrollbarsize + 5;
            } else {
                b -= this.scrollbarsize + 5;
                c -= this.scrollbarsize + 5;
            }
            var f = this.rowdetails && this.showrowdetailscolumn ? (1 + this.groups.length) * this.groupindentwidth : this.groups.length * this.groupindentwidth;
            c -= f;
            if (!this.columnsheader) return;
            var j = this.columnsheader.find("#columntable" + this.element.id);
            if (0 == j.length) return;
            var k = j.find(".jqx-grid-column-header");
            var l = 0;
            a.each(this.columns.records, function(e, f) {
                var g = a(k[e]);
                var h = false;
                var i = this.width;
                if (this.width.toString().indexOf("%") != -1 || void 0 != this._percentagewidth) {
                    if (void 0 != this._percentagewidth) i = parseFloat(this._percentagewidth) * c / 100; else i = parseFloat(this.width) * c / 100;
                    h = true;
                }
                if ("auto" != this.width && !this._width && !h) {
                    if (parseInt(g[0].style.width) != this.width) g.width(this.width);
                } else if (h) {
                    if (i < this.minwidth && "auto" != this.minwidth) {
                        i = this.minwidth;
                        this.width = i;
                    }
                    if (i > this.maxwidth && "auto" != this.maxwidth) {
                        i = this.maxwidth;
                        this.width = i;
                    }
                    if (parseInt(g[0].style.width) != i) {
                        g.width(i);
                        this.width = i;
                    }
                } else {
                    var j = Math.floor(b * (this.text.length / d.length));
                    if (isNaN(j)) j = this.minwidth;
                    if (1/0 == j) j = 0;
                    if (j < 0) {
                        $element = a("<span>" + this.text + "</span>");
                        a(document.body).append($element);
                        j = 10 + $element.width();
                        $element.remove();
                    }
                    if (j < this.minwidth) j = this.minwidth;
                    if (j > this.maxwidth) j = this.maxwidth;
                    this._width = "auto";
                    this.width = j;
                    g.width(this.width);
                }
                if (parseInt(g[0].style.left) != l) g.css("left", l);
                if (!(this.hidden && this.hideable)) l += this.width;
                this._requirewidthupdate = true;
            });
            this.columnsheader.width(2 + l);
            j.width(this.columnsheader.width());
            if (0 == l) this.columnsheader[0].style.visibility = "hidden"; else this.columnsheader[0].style.visibility = "inherit";
            this._resizecolumngroups();
            if (this.showfilterrow && this.filterrow) {
                this.filterrow.width(this.columnsheader.width());
                this._updatefilterrowui();
            }
            if (this.autowidth) this._arrange();
        },
        _rendercolumnheaders: function() {
            var b = this.that;
            if (!this.prerenderrequired) {
                if (this._rendersortcolumn) this._rendersortcolumn();
                if (this._renderfiltercolumn) this._renderfiltercolumn();
                if (this.showfilterrow && this.filterrow) {
                    this.filterrow.width(this.columnsheader.width());
                    this._updatefilterrowui();
                }
                return;
            }
            this._columnsbydatafield = new Array();
            this.columnsheader.find("#columntable" + this.element.id).remove();
            var c = a('<div id="columntable' + this.element.id + '" style="height: 100%; position: relative;"></div>');
            c[0].cells = new Array();
            var d = 0;
            var e = 0;
            var f = "";
            var g = this.host.width();
            var h = g;
            var i = new Array();
            var j = new Array();
            var k = this.rowdetails && this.showrowdetailscolumn ? (1 + this.groups.length) * this.groupindentwidth : this.groups.length * this.groupindentwidth;
            a.each(this.columns.records, function(a, c) {
                if (!(this.hidden && this.hideable)) if ("auto" != this.width && !this._width) if (this.width < this.minwidth && "auto" != this.minwidth) g -= this.minwidth; else if (this.width > this.maxwidth && "auto" != this.maxwidth) g -= this.maxwidth; else if (this.width.toString().indexOf("%") != -1) {
                    var c = 0;
                    var d = "hidden" == b.vScrollBar[0].style.visibility ? 0 : b.scrollbarsize + 5;
                    d += k;
                    c = parseFloat(this.width) * (h - d) / 100;
                    if (c < this.minwidth && "auto" != this.minwidth) c = this.minwidth;
                    if (c > this.maxwidth && "auto" != this.maxwidth) c = this.maxwidth;
                    g -= c;
                } else {
                    if ("string" == typeof this.width) this.width = parseInt(this.width);
                    g -= this.width;
                } else f += this.text;
                if (this.pinned || this.grouped || this.checkboxcolumn) {
                    if (b._haspinned) this.pinned = true;
                    i[i.length] = this;
                } else j[j.length] = this;
            });
            if (!this.rtl) {
                for (var l = 0; l < i.length; l++) this.columns.replace(l, i[l]);
                for (var m = 0; m < j.length; m++) this.columns.replace(i.length + m, j[m]);
            } else {
                var n = 0;
                i.reverse();
                for (var l = this.columns.records.length - 1; l >= this.columns.records.length - i.length; l--) this.columns.replace(l, i[n++]);
                for (var m = 0; m < j.length; m++) this.columns.replace(m, j[m]);
            }
            var o = this.headerZIndex;
            var p = b.groupable ? b.groups.length : 0;
            if (this.rowdetails && this.showrowdetailscolumn) p++;
            var q = b.columnsheader.height();
            if (this.showfilterrow) if (!this.columngroups) q = this.columnsheight; else q -= this.filterrowheight;
            var r = this._gettableheight();
            if (this.virtualsizeinfo && this.virtualsizeinfo.virtualheight > r && !this.scrollbarautoshow) if (this.groupable && this.groups.length > 0) if (this.dataview && this.dataview.loadedrootgroups && !this.groupsexpandedbydefault) {
                var s = 0;
                if (!this.pageable) var s = this.dataview.loadedrootgroups.length * this.rowsheight; else if (this.pageable) for (var t = 0; t < this.dataview.rows.length; t++) if (this.dataview.rows[t].group && 0 === this.dataview.rows[t].level) s += this.rowsheight;
                if (s > r) {
                    g -= this.scrollbarsize + 5;
                    h -= this.scrollbarsize + 5;
                }
            } else {
                g -= this.scrollbarsize + 5;
                h -= this.scrollbarsize + 5;
            } else if (!this.autoheight) {
                g -= this.scrollbarsize + 5;
                h -= this.scrollbarsize + 5;
            }
            h -= k;
            var u = function(a, c) {
                var d = b.columngroupslevel * b.columnsheight;
                d -= c.level * b.columnsheight;
                return d;
            };
            a.each(this.columns.records, function(i, j) {
                this.height = b.columnsheight;
                if (b.columngroups) if (b.columngroups.length) {
                    this.height = u(this.datafield, this);
                    q = this.height;
                }
                var k = b.toTP("jqx-grid-column-header") + " " + b.toTP("jqx-widget-header");
                if (b.rtl) k += " " + b.toTP("jqx-grid-column-header-rtl");
                var l = !b.rtl ? 150 + o - 1 : 150 + o + 1;
                var m = !b.rtl ? o-- : o++;
                var n = a('<div role="columnheader" style="z-index: ' + m + ';position: absolute; height: 100%;" class="' + k + '"><div style="height: 100%; width: 100%;"></div></div>');
                if (b.columngroups) {
                    n[0].style.height = q + "px";
                    n[0].style.bottom = "0px";
                    if (this.pinned) n[0].style.zIndex = l;
                }
                this.uielement = n;
                if ("" != this.classname && this.classname) n.addClass(this.classname);
                var r = this.width;
                var s = false;
                if (null === this.width) this.width = "auto";
                if (this.width.toString().indexOf("%") != -1 || void 0 != this._percentagewidth) {
                    if (void 0 != this._percentagewidth) r = parseFloat(this._percentagewidth) * h / 100; else r = parseFloat(this.width) * h / 100;
                    s = true;
                }
                if ("auto" != this.width && !this._width && !s) {
                    if (r < this.minwidth && "auto" != this.minwidth) {
                        r = this.minwidth;
                        this.width = r;
                    }
                    if (r > this.maxwidth && "auto" != this.maxwidth) {
                        r = this.maxwidth;
                        this.width = r;
                    }
                    n[0].style.width = parseInt(r) + "px";
                } else if (s) {
                    if (r < this.minwidth && "auto" != this.minwidth) r = this.minwidth;
                    if (r > this.maxwidth && "auto" != this.maxwidth) r = this.maxwidth;
                    if (void 0 == this._percentagewidth || this.width.toString().indexOf("%") != -1) this._percentagewidth = this.width;
                    n.width(r);
                    this.width = r;
                } else if (!this.hidden) {
                    var t = Math.floor(g * (this.text.length / f.length));
                    if (isNaN(t)) t = this.minwidth;
                    if (t < 0) {
                        $element = a("<span>" + this.text + "</span>");
                        a(document.body).append($element);
                        t = 10 + $element.width();
                        $element.remove();
                    }
                    if (t < this.minwidth) t = this.minwidth;
                    if (t > this.maxwidth) t = this.maxwidth;
                    this._width = "auto";
                    this.width = t;
                    r = this.width;
                    n.width(this.width);
                }
                if (this.hidden && this.hideable) n.css("display", "none");
                var v = a(n.children()[0]);
                var w = b.rtl ? b.toTP("jqx-grid-column-menubutton") + " " + b.toTP("jqx-grid-column-menubutton-rtl") : b.toTP("jqx-grid-column-menubutton");
                w += " " + b.toTP("jqx-icon-arrow-down");
                var x = a('<div style="height: ' + q + 'px; display: none; left: 100%; top: 0%; position: absolute;"><div class="' + w + '" style="width: 100%; height:100%;"></div></div>');
                if (!b.enableanimations) x.css("margin-left", -16);
                if (b.rtl) x.css("left", "0px");
                this.columnsmenu = x[0];
                c[0].cells[i] = n[0];
                x[0].style.width = parseInt(b.columnsmenuwidth) + "px";
                var y = b.columnsmenu;
                var z = false;
                var A = false;
                var B = b.groupable && p > 0 && d < p || b.rowdetails && d < p;
                if (b.rtl) {
                    B = b.groupable && p > 0 && d < p || b.rowdetails && d < p;
                    B &= i > b.columns.records.length - 1 - p;
                }
                if (B) {
                    d++;
                    y &= false;
                    this.sortable = false;
                    this.editable = false;
                    A = true;
                } else {
                    var C = null != this.renderer ? this.renderer(this.text, this.align, q) : b._rendercolumnheader(this.text, this.align, q, b);
                    if (null == C) C = b._rendercolumnheader(this.text, this.align, q, b);
                    if (null != this.renderer) C = a(C);
                    y &= true;
                    z = true;
                }
                if (b.WinJS) MSApp.execUnsafeLocalFunction(function() {
                    v.append(a(C));
                }); else if (this.renderer) v.append(a(C)); else if (C) v[0].innerHTML = C;
                if (null != C) {
                    var D = a('<div class="iconscontainer" style="height: ' + q + 'px; margin-left: -32px; display: block; position: absolute; left: 100%; top: 0%; width: 32px;"><div class="filtericon ' + b.toTP("jqx-widget-header") + '" style="height: ' + q + 'px; float: right; display: none; width: 16px;"><div class="' + b.toTP("jqx-grid-column-filterbutton") + '" style="width: 100%; height:100%;"></div></div><div class="sortasc ' + b.toTP("jqx-widget-header") + '" style="height: ' + q + 'px; float: right; display: none; width: 16px;"><div class="' + b.toTP("jqx-grid-column-sortascbutton") + " " + b.toTP("jqx-icon-arrow-up") + '" style="width: 100%; height:100%;"></div></div><div class="sortdesc ' + b.toTP("jqx-widget-header") + '" style="height: ' + q + 'px; float: right; display: none; width: 16px;"><div class="' + b.toTP("jqx-grid-column-sortdescbutton") + " " + b.toTP("jqx-icon-arrow-down") + '" style="width: 100%; height:100%;"></div></div></div>');
                    x.addClass(b.toTP("jqx-widget-header"));
                    v.append(D);
                    var E = D.children();
                    this.sortasc = E[1];
                    this.sortdesc = E[2];
                    this.filtericon = E[0];
                    this.iconscontainer = D;
                    if (b.rtl) {
                        D.css("margin-left", "0px");
                        D.css("left", "0px");
                        a(this.sortasc).css("float", "left");
                        a(this.filtericon).css("float", "left");
                        a(this.sortdesc).css("float", "left");
                    }
                    if (!b.autoshowfiltericon && this.filterable) a(this.filtericon).css("display", "block");
                }
                this.element = n[0];
                if (y) {
                    b._handlecolumnsmenu(b, v, n, x, this);
                    if (!this.menu) x.hide();
                }
                c.append(n);
                if (b.groupable && z) {
                    n[0].id = b.dataview.generatekey();
                    if (b._handlecolumnstogroupsdragdrop) b._handlecolumnstogroupsdragdrop(this, n); else throw new Error("jqxGrid: Missing reference to jqxgrid.grouping.js.");
                }
                if (b.columnsreorder && this.draggable && b._handlecolumnsdragreorder) b._handlecolumnsdragreorder(this, n);
                var F = this;
                b.addHandler(n, "click", function(a) {
                    if (F.checkboxcolumn) return true;
                    if (b.sorttogglestates > 0 && b._togglesort) if (!b._loading) b._togglesort(F);
                    a.preventDefault();
                    b._raiseEvent(7, {
                        column: F.getcolumnproperties(),
                        datafield: F.datafield,
                        originalEvent: a
                    });
                });
                if (F.resizable && b.columnsresize && !A) {
                    var G = false;
                    var H = "mousemove";
                    if (b.isTouchDevice() && true !== b.touchmode) {
                        G = true;
                        H = a.jqx.mobile.getTouchEventName("touchstart");
                    }
                    b.addHandler(n, H, function(c) {
                        var d = parseInt(c.pageX);
                        var e = 5;
                        var f = parseInt(n.coord().left);
                        if (b.hasTransform) f = a.jqx.utilities.getOffset(n).left;
                        if (b.resizing) return true;
                        if (b._handlecolumnsresize) {
                            if (G) {
                                var g = b.getTouches(c);
                                var h = g[0];
                                d = h.pageX;
                                e = 40;
                                if (d >= f + F.width - e) {
                                    b.resizablecolumn = {
                                        columnelement: n,
                                        column: F
                                    };
                                    n.css("cursor", "col-resize");
                                } else {
                                    n.css("cursor", "");
                                    b.resizablecolumn = null;
                                }
                                return true;
                            }
                            var i = F.width;
                            if (b.rtl) i = 0;
                            if (d >= f + i - e) if (d <= f + i + e) {
                                b.resizablecolumn = {
                                    columnelement: n,
                                    column: F
                                };
                                n.css("cursor", "col-resize");
                                return false;
                            } else {
                                n.css("cursor", "");
                                b.resizablecolumn = null;
                            } else {
                                n.css("cursor", "");
                                if (d < f + i - e) if (!F._animating && !F._menuvisible) n.mouseenter();
                                b.resizablecolumn = null;
                            }
                        }
                    });
                }
                n.css("left", e);
                if (!(this.hidden && this.hideable)) e += r;
                if (F.rendered) {
                    var I = F.rendered(a(v[0].firstChild), F.align, q);
                    if (I && null != D) D.hide();
                }
                if (F.checkboxcolumn) {
                    if (D) D.hide();
                    if (!b.host.jqxCheckBox) throw new Error("jqxGrid: Missing reference to jqxcheckbox.js");
                    v.html('<div style="cursor: pointer; margin-left: 5px; top: 50%; margin-top: -8px; position: relative;"></div>');
                    var J = v.find("div:first");
                    J.jqxCheckBox({
                        _canFocus: false,
                        disabled: b.disabled,
                        disabledContainer: true,
                        theme: b.theme,
                        enableContainerClick: false,
                        width: 16,
                        height: 16,
                        animationShowDelay: 0,
                        animationHideDelay: 0
                    });
                    F.checkboxelement = J;
                    var K = J.data().jqxCheckBox.instance;
                    b._checkboxcolumn = F;
                    K.updated = function(a, c, d) {
                        b._checkboxcolumnupdating = true;
                        if (b.disabled) {
                            J.jqxCheckBox({
                                disabled: b.disabled
                            });
                            c = d;
                        }
                        if (c) b.selectallrows(); else b.unselectallrows();
                        b._checkboxcolumnupdating = false;
                    };
                }
            });
            if (e > 0) this.columnsheader.width(2 + e); else this.columnsheader.width(e);
            this.columnsrow = c;
            b.columnsheader.append(c);
            if (this.showfilterrow && this._updatefilterrow) {
                if (!this.columngroups) c.height(this.columnsheight); else c.height(this.columngroupslevel * this.columnsheight);
                if (!this.filterrow) {
                    var v = a("<div></div>");
                    v[0].id = "filterrow." + this.element.id;
                    v.height(this.filterrowheight);
                    this.filterrow = v;
                }
                this.filterrow.width(2 + e);
                this.columnsheader.append(this.filterrow);
                this._updatefilterrow();
            }
            if (0 == e) c[0].style.visibility = "hidden"; else c[0].style.visibility = "inherit";
            c.width(e);
            if (this._handlecolumnsdragdrop) this._handlecolumnsdragdrop();
            if (this._handlecolumnsreorder) this._handlecolumnsreorder();
            if (this._rendersortcolumn) this._rendersortcolumn();
            if (this._renderfiltercolumn) this._renderfiltercolumn();
            if (this._handlecolumnsresize) this._handlecolumnsresize();
            if (this.columngroups) this._rendercolumngroups();
            if (this._updatecheckboxselection) this._updatecheckboxselection();
        },
        _rendercolumngroups: function() {
            if (!this.columngroups) return;
            var b = 0;
            for (var c = 0; c < this.columns.records.length; c++) if (this.columns.records[c].pinned) b++;
            var d = this.headerZIndex - b + this.columns.records.length;
            var e = this.that;
            var f = e.toTP("jqx-grid-column-header") + " " + e.toTP("jqx-grid-columngroup-header") + " " + e.toTP("jqx-widget-header");
            if (e.rtl) f += " " + e.toTP("jqx-grid-columngroup-header-rtl");
            var g = this.columnsheader.find("#columntable" + this.element.id);
            g.find("jqx-grid-columngroup-header").remove();
            for (var h = 0; h < this.columngroupslevel - 1; h++) for (var c = 0; c < this.columngroups.length; c++) {
                var i = this.columngroups[c];
                var j = i.level;
                if (j !== h) continue;
                var k = j * this.columnsheight;
                var l = 99999;
                if (i.groups) {
                    var m = function(a) {
                        var b = 0;
                        for (var c = 0; c < a.groups.length; c++) {
                            var d = a.groups[c];
                            if (!d.groups) {
                                if (!d.hidden) {
                                    b += d.width;
                                    l = Math.min(parseFloat(d.element.style.left), l);
                                }
                            } else b += m(d);
                        }
                        return b;
                    };
                    i.width = m(i);
                    i.left = l;
                    var n = this.columnsheight;
                    var o = d--;
                    var p = a('<div role="columnheader" style="z-index: ' + o + ';position: absolute;" class="' + f + '"></div>');
                    var q = a(this._rendercolumnheader(i.text, i.align, this.columnsheight, this));
                    if (i.renderer) {
                        var q = a("<div style='height: 100%; width: 100%;'></div>");
                        var r = i.renderer(i.text, i.align, n);
                        q.html(r);
                    }
                    p.append(q);
                    p[0].style.left = l + "px";
                    if (0 === l) p[0].style.borderLeftColor = "transparent";
                    p[0].style.top = k + "px";
                    p[0].style.height = n + "px";
                    p[0].style.width = -1 + i.width + "px";
                    g.append(p);
                    i.element = p;
                    if (i.rendered) i.rendered(q, i.align, n);
                }
            }
        },
        _resizecolumngroups: function() {
            if (!this.columngroups) return;
            for (var a = 0; a < this.columngroups.length; a++) {
                var b = this.columngroups[a];
                var c = b.level;
                var d = c * this.columnsheight;
                var e = 99999;
                if (b.groups) {
                    var f = function(a) {
                        var b = 0;
                        for (var c = 0; c < a.groups.length; c++) {
                            var d = a.groups[c];
                            if (!d.groups) {
                                if (!d.hidden) {
                                    b += d.width;
                                    e = Math.min(parseFloat(d.element.style.left), e);
                                }
                            } else b += f(d);
                        }
                        return b;
                    };
                    b.width = f(b);
                    b.left = e;
                    var g = this.columnsheight;
                    var h = b.element;
                    h[0].style.left = e + "px";
                    h[0].style.top = d + "px";
                    h[0].style.height = g + "px";
                    h[0].style.width = -1 + b.width + "px";
                }
            }
        },
        _handlecolumnsmenu: function(b, c, d, e, f) {
            b.dragmousedown = null;
            e[0].id = b.dataview.generatekey();
            c.append(e);
            d[0].columnsmenu = e[0];
            f.element = d[0];
            var g = this.columnsmenuwidth + 1;
            var h = function() {
                if (!f.menu) return false;
                if (!b.resizing) {
                    if (f._menuvisible && b._hasOpenedMenu) return false;
                    f._animating = true;
                    if (b.menuitemsarray && b.menuitemsarray.length > 0) if (!b.enableanimations) {
                        e.css("display", "block");
                        var a = !b.rtl ? -48 : 16;
                        f.iconscontainer.css("margin-left", a + "px");
                        f._animating = false;
                        f._menuvisible = true;
                    } else {
                        e.css("display", "block");
                        e.stop();
                        f.iconscontainer.stop();
                        if (!b.rtl) {
                            e.css("margin-left", "0px");
                            e.animate({
                                "margin-left": -g
                            }, "fast", function() {
                                e.css("display", "block");
                                f._animating = false;
                                f._menuvisible = true;
                            });
                        } else {
                            e.css("margin-left", -g);
                            e.animate({
                                "margin-left": "0px"
                            }, "fast", function() {
                                e.css("display", "block");
                                f._animating = false;
                                f._menuvisible = true;
                            });
                        }
                        var a = !b.rtl ? -(32 + g) : g;
                        f.iconscontainer.animate({
                            "margin-left": a
                        }, "fast");
                    }
                }
            };
            var i = "mouseenter";
            if (b.isTouchDevice()) i = "touchstart";
            b.addHandler(d, i, function(c) {
                var e = parseInt(c.pageX);
                var g = b.columnsresize && f.resizable ? 3 : 0;
                var i = parseInt(d.coord().left);
                if (b.hasTransform) i = a.jqx.utilities.getOffset(d).left;
                var j = f.width;
                if (b.rtl) j = 0;
                if (0 != g) if (e >= i + j - g) if (e <= i + j + g) return false;
                var k = b.vScrollInstance.isScrolling();
                if (f.menu && b.autoshowcolumnsmenubutton && !k && !b.disabled) h();
            });
            if (!b.autoshowcolumnsmenubutton) {
                e.css("display", "block");
                var j = !b.rtl ? -48 : 16;
                f.iconscontainer.css("margin-left", j + "px");
                if (!b.rtl) e.css({
                    "margin-left": -g
                }); else e.css({
                    "margin-left": "0px"
                });
            }
            b.addHandler(d, "mouseleave", function(c) {
                if (b.menuitemsarray && b.menuitemsarray.length > 0 && f.menu) {
                    var d = a.data(document.body, "contextmenu" + b.element.id);
                    if (void 0 != d && e[0].id == d.columnsmenu.id) return;
                    if (b.autoshowcolumnsmenubutton) if (!b.enableanimations) {
                        e.css("display", "none");
                        var h = !b.rtl ? -32 : 0;
                        f.iconscontainer.css("margin-left", h + "px");
                        f._menuvisible = false;
                    } else {
                        if (!b.rtl) e.css("margin-left", -g); else e.css("margin-left", "0px");
                        e.stop();
                        f.iconscontainer.stop();
                        if (!b.rtl) e.animate({
                            "margin-left": 0
                        }, "fast", function() {
                            e.css("display", "none");
                            f._menuvisible = false;
                        }); else e.animate({
                            "margin-left": -g
                        }, "fast", function() {
                            e.css("display", "none");
                            f._menuvisible = false;
                        });
                        var h = !b.rtl ? -32 : 0;
                        f.iconscontainer.animate({
                            "margin-left": h
                        }, "fast");
                    }
                }
            });
            var k = true;
            var l = "";
            var m = a(f.filtericon);
            b.addHandler(e, "mousedown", function(c) {
                if (!b.gridmenu) b._initmenu();
                k = !a.data(b.gridmenu[0], "contextMenuOpened" + b.gridmenu[0].id);
                l = a.data(document.body, "contextmenu" + b.element.id);
                if (null != l) l = l.column.datafield;
            });
            b.addHandler(m, "mousedown", function(c) {
                if (!b.gridmenu) b._initmenu();
                k = !a.data(b.gridmenu[0], "contextMenuOpened" + b.gridmenu[0].id);
                l = a.data(document.body, "contextmenu" + b.element.id);
                if (null != l) l = l.column.datafield;
            });
            var n = function() {
                if (!f.menu) return false;
                if (!b.gridmenu) b._initmenu();
                if (b.disabled) return false;
                for (var c = 0; c < b.columns.records.length; c++) if (b.columns.records[c].datafield != f.datafield) b.columns.records[c]._menuvisible = false;
                var d = e.coord(true);
                var g = e.height();
                if (!k) {
                    k = true;
                    if (l == f.datafield) {
                        b._closemenu();
                        return false;
                    }
                }
                var h = b.host.coord(true);
                if (b.hasTransform) {
                    h = a.jqx.utilities.getOffset(b.host);
                    d = a.jqx.utilities.getOffset(e);
                }
                if (h.left + b.host.width() > parseInt(d.left) + b.gridmenu.width()) b.gridmenu.jqxMenu("open", d.left, d.top + g); else b.gridmenu.jqxMenu("open", e.width() + d.left - b.gridmenu.width(), d.top + g);
                if (b.gridmenu.width() < 100) b._arrangemenu();
                b._hasOpenedMenu = true;
                var i = b._getmenuitembyindex(0);
                var j = b._getmenuitembyindex(1);
                var m = b._getmenuitembyindex(2);
                var n = b._getmenuitembyindex(3);
                var o = b._getmenuitembyindex(4);
                var p = b._getmenuitembyindex(5);
                if (null != i && null != j && null != m) {
                    var q = f.sortable && b.sortable;
                    b.gridmenu.jqxMenu("disable", i.id, !q);
                    b.gridmenu.jqxMenu("disable", j.id, !q);
                    b.gridmenu.jqxMenu("disable", m.id, !q);
                    if (void 0 != f.displayfield) if (b.sortcolumn == f.displayfield) {
                        var r = b.getsortinformation();
                        if (q) if (r.sortdirection.ascending) b.gridmenu.jqxMenu("disable", i.id, true); else b.gridmenu.jqxMenu("disable", j.id, true);
                    } else b.gridmenu.jqxMenu("disable", m.id, true);
                }
                if (null != n && null != o) if (!b.groupable || !f.groupable) {
                    b.gridmenu.jqxMenu("disable", o.id, true);
                    b.gridmenu.jqxMenu("disable", n.id, true);
                } else if (b.groups && b.groups.indexOf(f.datafield) != -1) {
                    b.gridmenu.jqxMenu("disable", n.id, true);
                    b.gridmenu.jqxMenu("disable", o.id, false);
                } else {
                    b.gridmenu.jqxMenu("disable", n.id, false);
                    b.gridmenu.jqxMenu("disable", o.id, true);
                }
                if (null != p) {
                    b._updatefilterpanel(b, p, f);
                    var s = 0;
                    if (b.sortable && b._togglesort && b.showsortmenuitems) s += 3;
                    if (b.groupable && b.addgroup && b.showgroupmenuitems) s += 2;
                    var t = 27 * s + 3;
                    if (a.jqx.browser.msie && a.jqx.browser.version < 8) {
                        t += 20;
                        a(p).height(190);
                    }
                    if (b.filterable && b.showfiltermenuitems) if (!f.filterable) {
                        b.gridmenu.height(t);
                        a(p).css("display", "none");
                    } else {
                        b.gridmenu.height(t + 180);
                        a(p).css("display", "block");
                    }
                }
                a.data(document.body, "contextmenu" + b.element.id, {
                    column: f,
                    columnsmenu: e[0]
                });
            };
            b.addHandler(m, "click", function(a) {
                if (!f.menu) return false;
                if (!b.showfilterrow) {
                    if ("block" != e[0].style.display) d.trigger("mouseenter");
                    setTimeout(function() {
                        if ("block" != e[0].style.display) d.trigger("mouseenter");
                        n();
                    }, 200);
                }
                return false;
            });
            b.addHandler(e, "click", function(a) {
                if (!f.menu) return false;
                n();
                return false;
            });
            if (b.isTouchDevice()) b.addHandler(e, a.jqx.mobile.getTouchEventName("touchstart"), function(a) {
                if (!f.menu) return false;
                if (!b._hasOpenedMenu) n(); else b._closemenu();
                return false;
            });
        },
        _removecolumnhandlers: function(b) {
            var c = this.that;
            var d = a(b.element);
            if (d.length > 0) {
                c.removeHandler(d, "mouseenter");
                c.removeHandler(d, "mouseleave");
                var e = a(b.filtericon);
                c.removeHandler(e, "mousedown");
                c.removeHandler(e, "click");
                c.removeHandler(d, "click");
                c.removeHandler(d, "mousemove");
                if (c.columnsreorder) {
                    c.removeHandler(d, "mousedown.drag");
                    c.removeHandler(d, "mousemove.drag");
                }
                c.removeHandler(d, "dragstart");
                if (d[0].columnsmenu) {
                    var f = a(d[0].columnsmenu);
                    c.removeHandler(f, "click");
                    c.removeHandler(f, "mousedown");
                    c.removeHandler(f, a.jqx.mobile.getTouchEventName("touchstart"));
                }
            }
        },
        _rendercolumnheader: function(a, b, c, d) {
            var e = "4px";
            if (d.columngroups) {
                e = c / 2 - this._columnheight / 2;
                if (e < 0) e = 4;
                e += "px";
            } else if (25 != this.columnsheight) {
                e = this.columnsheight / 2 - this._columnheight / 2;
                if (e < 0) e = 4;
                e += "px";
            }
            if (this.enableellipsis) return '<div style="padding-bottom: 2px; overflow: hidden; text-overflow: ellipsis; text-align: ' + b + "; margin-left: 4px; margin-right: 2px; margin-bottom: " + e + "; margin-top: " + e + ';"><span style="text-overflow: ellipsis; cursor: default;">' + a + "</span></div>";
            if ("center" == b || "middle" == b) return '<div style="padding-bottom: 2px; text-align: center; margin-top: ' + e + ';"><a href="#">' + a + "</a></div>";
            var f = '<a style="margin-top: ' + e + "; float: " + b + ';" href="#">' + a + "</a>";
            return f;
        },
        _renderrows: function(b, c, d) {
            var e = this.that;
            if ((this.pageable || this.groupable) && (this.autoheight || this.autorowheight)) if (null != this.table && null != this.table[0].rows && this.table[0].rows.length < this.dataview.rows.length) e.prerenderrequired = true;
            if (!this.pageable && (this.autoheight || this.autorowheight) && (this.virtualmode || this.unboundmode)) {
                var f = this.source.totalrecords;
                if (!isNaN(f)) if (null != this.table && null != this.table[0].rows && this.table[0].rows.length != f) e.prerenderrequired = true;
            }
            if ((this.autoheight || this.autorowheight) && !e.prerenderrequired) if (this.table && this.table[0].rows) {
                if (this.table[0].rows.length < this.dataview.records.length) if (this.pageable && this.table[0].rows.length < this.dataview.pagesize) e.prerenderrequired = true; else if (!this.pageable) e.prerenderrequired = true;
                if (this.table[0].rows.length < this.dataview.cachedrecords.length) if (this.pageable && this.table[0].rows.length < this.dataview.pagesize) e.prerenderrequired = true; else if (!this.pageable) e.prerenderrequired = true;
            }
            e._prerenderrows(b);
            if (e._requiresupdate) {
                e._requiresupdate = false;
                e._updatepageviews();
            }
            var g = function() {
                if (e._loading) return;
                if (e.WinJS) MSApp.execUnsafeLocalFunction(function() {
                    e._rendervisualrows();
                }); else e._rendervisualrows();
                if (e.virtualmode && e.showaggregates && e._updateaggregates) e.refreshaggregates();
            };
            var h = a.jqx.browser.msie && a.jqx.browser.version < 10;
            if (this.virtualmode) {
                var i = function() {
                    if (e.rendergridrows) {
                        var a = e._startboundindex;
                        if (void 0 == a) a = 0;
                        var b = a + 1 + e.dataview.pagesize;
                        if (null != a && null != b) {
                            var d = e.source._source ? true : false;
                            var f = !d ? e.source.recordstartindex : e.source._source.recordstartindex;
                            if (f != a || true == c) {
                                if (!d) {
                                    e.source.recordstartindex = a;
                                    e.source.recordendindex = b;
                                } else {
                                    if (b >= e.source._source.totalrecords) {
                                        b = e.source._source.totalrecords;
                                        a = b - e.dataview.pagesize - 1;
                                        if (a < 0) a = 0;
                                        if (e.source._source.recordendindex == b && e.source._source.recordstartindex == a) return;
                                    }
                                    e.source._source.recordstartindex = a;
                                    e.source._source.recordendindex = b;
                                }
                                e.updatebounddata("cells");
                            }
                        }
                    }
                };
                if (this.loadondemand) {
                    g();
                    i();
                    this.loadondemand = false;
                }
                var j = void 0 == this._browser ? this._isIE10() : this._browser;
                if (this.editable && this.editcell && !this.vScrollInstance.isScrolling() && !this.hScrollInstance.isScrolling()) g(); else if (this.autoheight) g(); else if (j || h || navigator && navigator.userAgent.indexOf("Safari") != -1) {
                    if (null != this._scrolltimer) clearTimeout(this._scrolltimer);
                    this._scrolltimer = setTimeout(function() {
                        g();
                    }, 5);
                } else g();
            } else {
                if ("deferred" == this.scrollmode && (this.hScrollInstance.isScrolling() || this.vScrollInstance.isScrolling())) {
                    if (null != this._scrolltimer) clearInterval(this._scrolltimer);
                    var k = this._getfirstvisualrow();
                    if (null != k) {
                        var l = function(b) {
                            if (null == k) return "";
                            var c = "<table>";
                            var d = e.deferreddatafields;
                            if (null == d) if (e.columns.records.length > 0) {
                                d = new Array();
                                d.push(e.columns.records[0].displayfield);
                            }
                            for (var f = 0; f < d.length; f++) {
                                var g = d[f];
                                var h = e._getcolumnbydatafield(g);
                                if (h) {
                                    var i = e._getcellvalue(h, k);
                                    if ("" != h.cellsformat) if (a.jqx.dataFormat) if (a.jqx.dataFormat.isDate(i)) i = a.jqx.dataFormat.formatdate(i, h.cellsformat, e.gridlocalization); else if (a.jqx.dataFormat.isNumber(i)) i = a.jqx.dataFormat.formatnumber(i, h.cellsformat, e.gridlocalization);
                                    c += "<tr><td>" + i + "</td></tr>";
                                }
                            }
                            c += "</table>";
                            return c;
                        };
                        var m = this.scrollfeedback ? this.scrollfeedback(k.bounddata) : l(k.bounddata);
                        if (m != this._scrollelementcontent) {
                            this._scrollelement[0].innerHTML = m;
                            this._scrollelementcontent = m;
                        }
                    }
                    this._scrollelement.css("visibility", "visible");
                    this._scrollelementoverlay.css("visibility", "visible");
                    this._scrollelement.css("margin-top", -this._scrollelement.height() / 2);
                    this._scrolltimer = setInterval(function() {
                        if (!e.hScrollInstance.isScrolling() && !e.vScrollInstance.isScrolling()) {
                            g();
                            e._scrollelement.css("visibility", "hidden");
                            e._scrollelementoverlay.css("visibility", "hidden");
                            clearInterval(e._scrolltimer);
                            if (k) e.ensurerowvisible(k.visibleindex);
                        }
                    }, 100);
                    return;
                }
                if (navigator && navigator.userAgent.indexOf("Chrome") == -1 && navigator.userAgent.indexOf("Safari") != -1) this._updatedelay = 1;
                if (void 0 != this.touchDevice && true == this.touchDevice) this._updatedelay = 5;
                var j = void 0 == this._browser ? this._isIE10() : this._browser;
                if (j || h) this._updatedelay = 5;
                if (j && this.hScrollInstance.isScrolling()) {
                    g();
                    return;
                }
                if (a.jqx.browser.mozilla && 0 == this._updatedelay && (this.vScrollInstance.isScrolling() || this.hScrollInstance.isScrolling())) this._updatedelay = 0;
                if (null != this.updatedelay) this._updatedelay = this.updatedelay;
                if (0 == this._updatedelay) g(); else {
                    var n = this._jqxgridrendertimer;
                    if (null != n) clearTimeout(n);
                    if (this.vScrollInstance.isScrolling() || this.hScrollInstance.isScrolling()) {
                        n = setTimeout(function() {
                            g();
                        }, this._updatedelay);
                        this._jqxgridrendertimer = n;
                    } else {
                        this._jqxgridrendertimer = n;
                        g();
                    }
                }
            }
            if (e.autorowheight && !e.autoheight) if (this._pageviews.length > 0) {
                var o = this._gettableheight();
                var p = this._pageviews[0].height;
                if (p > o) {
                    if (this.pageable && this.gotopage) {
                        p = this._pageviews[0].height;
                        if (p < 0) p = this._pageviews[0].height;
                    }
                    if ("visible" != this.vScrollBar.css("visibility")) this.vScrollBar.css("visibility", "visible");
                    if (p <= o || this.autoheight) this.vScrollBar.css("visibility", "hidden");
                    if (p - o > 0) {
                        if ("deferred" != this.scrollmode) {
                            var q = p - o;
                            var r = this.vScrollInstance.max;
                            this.vScrollBar.jqxScrollBar({
                                max: q
                            });
                            if (Math.round(q) != Math.round(r)) this.vScrollBar.jqxScrollBar({
                                value: 0
                            });
                        }
                    } else this.vScrollBar.jqxScrollBar({
                        value: 0,
                        max: p
                    });
                } else {
                    if (!this._loading) this.vScrollBar.css("visibility", "hidden");
                    this.vScrollBar.jqxScrollBar({
                        value: 0
                    });
                }
                this._arrange();
                if (this.virtualsizeinfo) this.virtualsizeinfo.virtualheight = p;
            }
        },
        scrolling: function() {
            var a = this.vScrollInstance.isScrolling();
            var b = this.hScrollInstance.isScrolling();
            return {
                vertical: a,
                horizontal: b
            };
        },
        _renderhorizontalscroll: function() {
            var a = this.hScrollInstance;
            var b = a.value;
            if ("hidden" === this.hScrollBar.css("visibility")) {
                a.value = 0;
                b = 0;
            }
            var c = parseInt(b);
            if (null == this.table) return;
            var d = this.table[0].rows.length;
            var e = this.columnsrow;
            var f = this.groupable && this.groups.length > 0 ? this.groups.length : 0;
            var g = this.columns.records.length - f;
            var h = this.columns.records;
            var i = 0 == this.dataview.rows.length;
            if (this.rtl) if ("hidden" != this.hScrollBar.css("visibility")) c = a.max - c;
            if (i && !this._haspinned) {
                for (var j = 0; j < d; j++) {
                    var k = this.table[0].rows[j];
                    for (var l = 0; l < f + g; l++) {
                        var m = k.cells[l];
                        if (void 0 != m) {
                            var n = h[l];
                            if (n.pinned) {
                                m.style.marginLeft = c + "px";
                                if (0 == j) {
                                    var o = e[0].cells[l];
                                    o.style.marginLeft = c + "px";
                                }
                            }
                        }
                    }
                }
                this.table[0].style.marginLeft = -c + "px";
                e[0].style.marginLeft = -c + "px";
            } else if (this._haspinned || void 0 == this._haspinned) {
                for (var j = 0; j < d; j++) {
                    var k = this.table[0].rows[j];
                    for (var l = 0; l < f + g; l++) {
                        var m = k.cells[l];
                        if (void 0 != m) {
                            var n = h[l];
                            if (n.pinned) {
                                if (0 == c && "" == m.style.marginLeft) continue;
                                var p = null;
                                var q = null;
                                if (this.showfilterrow && this.filterrow) if (this.filterrow[0].cells) q = this.filterrow[0].cells[l];
                                if (this.showaggregates) if (this.statusbar[0].cells) p = this.statusbar[0].cells[l];
                                if (!this.rtl) {
                                    m.style.marginLeft = c + "px";
                                    if (0 == j) {
                                        var o = e[0].cells[l];
                                        o.style.marginLeft = c + "px";
                                        if (p) p.style.marginLeft = c + "px";
                                        if (q) q.style.marginLeft = c + "px";
                                    }
                                } else {
                                    m.style.marginLeft = -parseInt(b) + "px";
                                    if (0 == j) {
                                        var o = e[0].cells[l];
                                        o.style.marginLeft = -parseInt(b) + "px";
                                        if (p) p.style.marginLeft = -parseInt(b) + "px";
                                        if (q) q.style.marginLeft = -parseInt(b) + "px";
                                    }
                                }
                            }
                        }
                    }
                }
                this.table[0].style.marginLeft = -c + "px";
                e[0].style.marginLeft = -c + "px";
            } else if (false == this._haspinned) {
                this.table[0].style.marginLeft = -c + "px";
                e[0].style.marginLeft = -c + "px";
            }
            if (this.showaggregates) if (this.statusbar[0].cells) {
                var r = 0;
                if (this.rtl) if ("hidden" != this.vScrollBar.css("visibility")) if ("hidden" != this.hScrollBar.css("visibility")) r = 2 + parseInt(this.hScrollBar.css("left"));
                this.statusbar[0].style.marginLeft = -c + r + "px";
            }
            if (this.showfilterrow && this.filterrow) if (this.filterrow[0].cells) this.filterrow[0].style.marginLeft = -c + "px";
        },
        _updaterowdetailsvisibility: function() {
            if (this.rowdetails) for (var b = 0; b < this._rowdetailselementscache.length; b++) a(this._rowdetailselementscache[b]).css("display", "none");
        },
        _getvisualcolumnsindexes: function(a, b, c, d, e) {
            if (this.rowdetails || this.rtl || this.editcell || this.width && this.width.toString().indexOf("%") >= 0 || this.exporting) return {
                start: 0,
                end: c + d
            };
            var f = 0;
            var g = -1;
            var h = c + d;
            var i = false;
            if (this.autorowheight) return {
                start: 0,
                end: c + d
            };
            if (!e) for (var j = 0; j < c + d; j++) {
                var k = j;
                if (!i) if (this.columns.records[j].pinned) i = true;
                if (!this.columns.records[j].hidden) f += this.columns.records[j].width;
                if (f >= a && g == -1) g = j;
                if (f > b + a) {
                    h = j;
                    break;
                }
            }
            h++;
            if (h > c + d) h = c + d;
            if (g == -1 || i) g = 0;
            return {
                start: g,
                end: h
            };
        },
        _getfirstvisualrow: function() {
            var a = this.vScrollInstance;
            var b = a.value;
            var c = parseInt(b);
            if (0 == this._pagescache.length) {
                this.dataview.updateview();
                this._loadrows();
            }
            if ("visible" != this.vScrollBar[0].style.visibility) c = 0;
            if (!this.pageable) {
                var d = this._findvisiblerow(c, this._pageviews);
                if (d == -1) return null;
                if (d != this.dataview.pagenum) {
                    this.dataview.pagenum = d;
                    this.dataview.updateview();
                    this._loadrows();
                } else if (!this._pagescache[this.dataview.pagenum]) this._loadrows();
            }
            var e = this._findvisiblerow(c, this._pagescache[this.dataview.pagenum]);
            var f = this._pagescache[this.dataview.pagenum];
            if (f && f[0]) return f[e];
        },
        _rendervisualrows: function() {
            if (!this.virtualsizeinfo) return;
            var b = this.vScrollInstance;
            var c = this.hScrollInstance;
            var d = b.value;
            var e = c.value;
            var f = parseInt(d);
            var g = parseInt(e);
            var h = this._gettableheight();
            var i = void 0 != this._hostwidth ? this._hostwidth : this.host.width();
            if ("visible" == this.hScrollBar[0].style.visibility) h += 29;
            if ("deferred" == this.scrollmode && 0 != this._newmax) if (f > this._newmax && null != this._newmax) f = this._newmax;
            var j = b.isScrolling() || c.isScrolling() || this._keydown;
            var k = this.groupable && this.groups.length > 0;
            this.visiblerows = new Array();
            this.hittestinfo = new Array();
            if (this.editcell && void 0 == this.editrow) this._hidecelleditor(false);
            if (void 0 != this.editrow) this._hideeditors();
            if (this.virtualmode && !this.pageable) this._pagescache = new Array();
            if (0 == this._pagescache.length) {
                this.dataview.updateview();
                this._loadrows();
            }
            if ("hidden" == this.vScrollBar[0].style.visibility) f = 0;
            if (!this.pageable) {
                var l = this._findvisiblerow(f, this._pageviews);
                if (l == -1) {
                    this._clearvisualrows();
                    this._renderemptyrow();
                    this._updaterowdetailsvisibility();
                    return;
                }
                if (l != this.dataview.pagenum) {
                    this.dataview.pagenum = l;
                    this.dataview.updateview();
                    this._loadrows();
                } else if (!this._pagescache[this.dataview.pagenum]) this._loadrows();
            }
            var m = this.groupable && this.groups.length > 0 ? this.groups.length : 0;
            if (!this.columns.records) return;
            var n = this.columns.records.length - m;
            var o = this._findvisiblerow(f, this._pagescache[this.dataview.pagenum]);
            var p = this._pagescache[this.dataview.pagenum];
            var q = o;
            if (q < 0) q = 0;
            var r = 0;
            var s = 0;
            var t = 0;
            var u = 0;
            var v = this.virtualsizeinfo.visiblerecords;
            var w = this.groupable ? this.groups.length : 0;
            var x = this.toTP("jqx-grid-cell") + " " + this.toTP("jqx-item");
            if (this.rtl) x += " " + this.toTP("jqx-grid-cell-rtl");
            if ((this.autoheight || this.autorowheight) && this.pageable) if (!this.groupable || this.groupable && 0 === this.groups.length) v = this.dataview.pagesize;
            if (k) x = " " + this.toTP("jqx-grid-group-cell");
            if (this.isTouchDevice()) x += " " + this.toTP("jqx-touch");
            if (this.autorowheight) x += " jqx-grid-cell-wrap";
            var y = this.rowsheight;
            var z = q;
            var A = this._rendercell;
            var B = true;
            var C = this._getvisualcolumnsindexes(g, i, m, n, k);
            var D = C.start;
            var E = C.end;
            if ((this.autoheight || this.pageable) && this.autorowheight) if (this._pageviews[0]) this._oldpageviewheight = this._pageviews[0].height;
            if (this.autorowheight) q = 0;
            if (q >= 0) {
                this._updaterowdetailsvisibility();
                this._startboundindex = null != p ? p[q].bounddata.boundindex : 0;
                this._startvisibleindex = null != p ? p[q].bounddata.visibleindex : 0;
                for (var F = 0; F < v && s < v; F++) {
                    var G = void 0 != p ? p[q + F] : null;
                    if (null == G) {
                        q = -F;
                        if (this._pagescache[this.dataview.pagenum + 1]) {
                            p = this._pagescache[this.dataview.pagenum + 1];
                            this.dataview.pagenum++;
                        } else {
                            var H = this._pageviews.length;
                            do if (this.dataview.pagenum < this._pageviews.length - 1) {
                                this.dataview.pagenum++;
                                p = void 0;
                                if (this._pageviews[this.dataview.pagenum].height > 0) {
                                    this.dataview.updateview();
                                    this._loadrows();
                                    p = this._pagescache[this.dataview.pagenum];
                                }
                            } else {
                                p = void 0;
                                break;
                            } while (void 0 == p && this.dataview.pagenum < H);
                        }
                        if (void 0 != p) G = p[q + F];
                    }
                    if (null != G) {
                        if (G.hidden) continue;
                        this._endboundindex = this._startboundindex + F;
                        this._endvisibleindex = this._startvisibleindex + F;
                        if (0 == F) {
                            var I = Math.abs(f - G.top);
                            this.table[0].style.top = -I + "px";
                            u = -I;
                        }
                        var J = this.table[0].rows[s];
                        if (!J) continue;
                        if (parseInt(J.style.height) != G.height) J.style.height = parseInt(G.height) + "px";
                        t += G.height;
                        var K = this.rowdetails && G.rowdetails;
                        var L = !G.rowdetailshidden;
                        if (K && L) {
                            J.style.height = parseInt(G.height - G.rowdetailsheight) + "px";
                            v++;
                        }
                        var M = this._isrowselected(B, G);
                        for (var N = D; N < E; N++) {
                            var O = N;
                            this._rendervisualcell(A, x, M, K, L, k, w, J, G, O, s, j);
                        }
                        if (void 0 != G.group && this._rendergroup) this._rendergroup(w, J, G, m, n, s, i);
                        if (this.autorowheight && (this.autoheight || this.pageable)) {
                            var y = this.rowsheight;
                            for (var N = D; N < E; N++) {
                                if (this.editable && this.editcell && this.editcell.column == this.columns.records[N].datafield && this.editcell.row == this.getboundindex(G)) {
                                    y = Math.max(y, this.editcell.editor.height());
                                    continue;
                                }
                                if (J.cells[N].firstChild) y = Math.max(y, 8 + parseInt(J.cells[N].firstChild.offsetHeight));
                            }
                            J.style.height = parseInt(y) + "px";
                            this.heights[this._startboundindex + F] = y;
                            if (K && L) y += G.rowdetailsheight;
                            G.height = y;
                        }
                        this.visiblerows[this.visiblerows.length] = G;
                        this.hittestinfo[this.hittestinfo.length] = {
                            row: G,
                            visualrow: J,
                            details: false
                        };
                        if (K && L) {
                            s++;
                            var J = this.table[0].rows[s];
                            this._renderrowdetails(x, J, G, m, n, s);
                            this.visiblerows[this.visiblerows.length] = G;
                            this.hittestinfo[this.hittestinfo.length] = {
                                row: G,
                                visualrow: J,
                                details: true
                            };
                        }
                        if (!this.autorowheight) if (t + u >= h) break;
                    } else {
                        cansetheight = true;
                        this._clearvisualrow(g, k, s, m, n);
                        if (t + r + u <= h) r += y;
                    }
                    s++;
                }
                this._horizontalvalue = g;
                if (r > 0) if ("visible" == this.vScrollBar[0].style.visibility) {
                    var P = parseInt(this.table.css("top"));
                    var Q = this._pageviews[this._pageviews.length - 1];
                    var R = b.max;
                    var S = Q.top + Q.height - h;
                    if ("visible" == this.hScrollBar.css("visibility")) S += this.scrollbarsize + 20;
                    if (R != S && !this.autorowheight) if (S >= 0) if ("deferred" != this.scrollmode) {
                        b.max = S;
                        b.setPosition(b.max);
                    } else if (this._newmax != S) {
                        this._newmax = S;
                        this._rendervisualrows();
                    }
                }
            }
            if ((this.autoheight || this.pageable) && this.autorowheight) {
                this._pagescache = new Array();
                var T = 0;
                var U = 0;
                for (var V = 0; V < this.visiblerows.length; V++) {
                    var W = this.visiblerows[V];
                    W.top = T;
                    T += W.height;
                    U += W.height;
                    var K = this.rowdetails && W.rowdetails;
                    var L = !W.rowdetailshidden;
                    var J = this.table[0].rows[V];
                    if (K && L) V++;
                    for (var N = D; N < E; N++) {
                        var X = this.columns.records[N];
                        if (!X.hidden) if (!X.cellsrenderer) {
                            var Y = J.cells[N];
                            var Z = 0;
                            if (Y.firstChild) {
                                var Z = (W.height - parseInt(Y.firstChild.offsetHeight) - 8) / 2;
                                if (K && L) var Z = (W.height - W.rowdetailsheight - a(Y.firstChild).height() - 8) / 2;
                            } else var Z = (W.height - parseInt(a(Y).height()) - 8) / 2;
                            if (Z >= 0) {
                                Z = parseInt(Z) + 4;
                                if (Y.firstChild) if (Y.firstChild.className.indexOf("jqx-grid-groups-row") == -1) if ("checkbox" != X.columntype && "button" != X.columntype) {
                                    if (this.editable && this.editcell && this.editcell.column == X.datafield && this.editcell.row == this.getboundindex(W)) continue;
                                    Y.firstChild.style.marginTop = Z + "px";
                                }
                            }
                        }
                    }
                }
                if (this._pageviews[0]) this._pageviews[0].height = U;
                this._arrange();
            }
            this._renderemptyrow();
        },
        _hideemptyrow: function() {
            if (!this.showemptyrow) return;
            if (!this.table) return;
            if (!this.table[0].rows) return;
            var b = this.table[0].rows[0];
            if (!b) return;
            var c = false;
            for (var d = 0; d < b.cells.length; d++) {
                var e = a(b.cells[d]);
                if ("none" != e.css("display") && !c) if (e.width() == this.host.width() || e.text() == this.gridlocalization.emptydatastring) {
                    e[0].checkbox = null;
                    e[0].button = null;
                    c = true;
                    e[0].innerHTML = "";
                }
            }
        },
        _renderemptyrow: function() {
            if (this._loading) return;
            if (0 == this.dataview.records.length && this.showemptyrow) {
                var b = false;
                var c = this.toTP("jqx-grid-cell");
                if (this.table && this.table.length > 0 && this.table[0].rows && this.table[0].rows.length > 0) {
                    var d = this.table[0].rows[0];
                    this.table[0].style.top = "0px";
                    for (var e = 0; e < d.cells.length; e++) {
                        var f = a(d.cells[e]);
                        if ("none" != f.css("display") && !b) {
                            f[0].checkbox = null;
                            f[0].button = null;
                            f[0].className = c;
                            b = true;
                            f[0].innerHTML = "";
                            var g = a("<span style='white-space: nowrap; float: left; margin-left: 50%; position: relative;'></span>");
                            g.text(this.gridlocalization.emptydatastring);
                            f.append(g);
                            var h = 0;
                            if (!this.oldhscroll) {
                                h = parseInt(this.table[0].style.marginLeft);
                                if (this.rtl) {
                                    f.css("z-index", 999);
                                    f.css("overflow", "visible");
                                }
                            }
                            g.css("left", -h - g.width() / 2);
                            g.css("top", this._gettableheight() / 2 - g.height() / 2);
                            if (a.jqx.browser.msie && a.jqx.browser.version < 8) {
                                g.css("margin-left", "0px");
                                g.css("left", this.host.width() / 2 - g.width() / 2);
                            }
                            var i = Math.abs(parseInt(this.table[0].style.top));
                            if (isNaN(i)) i = 0;
                            a(d).height(this._gettableheight() + i);
                            f.css("margin-left", "0px");
                            f.width(this.host.width());
                            if (this.table.width() < this.host.width()) this.table.width(this.host.width());
                        }
                        f.addClass(this.toThemeProperty("jqx-grid-empty-cell"));
                    }
                }
            }
        },
        _clearvisualrows: function() {
            var a = this.virtualsizeinfo.visiblerecords;
            var b = this.hScrollInstance;
            var c = b.value;
            var d = parseInt(c);
            var e = this.groupable && this.groups.length > 0;
            if (!this.columns.records) return;
            for (var f = 0; f < a; f++) this._clearvisualrow(d, e, f, 0, this.columns.records.length);
        },
        _iscellselected: function(a, b, c) {
            var d = false;
            var e = 0;
            if (this.virtualmode && this.pageable && this.groupable) if (this.groups.length > 0) e = this.dataview.pagesize * this.dataview.pagenum;
            if (this.groups.length > 0 && this.pageable && this.groupable) {
                var f = this.getrowboundindexbyid(b.bounddata.uid);
                for (var g in this.selectedcells) if (g == f + "_" + c) d = true;
                return d;
            }
            if (a && null != b.bounddata) if ("singlerow" != this.selectionmode) {
                if (this.dataview.filters.length > 0) {
                    if (!this.virtualmode && void 0 != b.bounddata.dataindex) {
                        for (var g in this.selectedcells) if (g == e + b.bounddata.dataindex + "_" + c) d = true;
                    } else for (var g in this.selectedcells) if (g == e + b.bounddata.boundindex + "_" + c) d = true;
                } else for (var g in this.selectedcells) if (g == e + b.bounddata.boundindex + "_" + c) {
                    d = true;
                    break;
                }
            } else if (this.dataview.filters.length > 0) {
                if (!this.virtualmode && void 0 != b.bounddata.dataindex) {
                    for (var g in this.selectedcells) if (g == e + b.bounddata.dataindex + "_" + c) {
                        d = true;
                        break;
                    }
                } else for (var g in this.selectedcells) if (g == e + b.bounddata.boundindex + "_" + c) {
                    d = true;
                    break;
                }
            } else for (var g in this.selectedcells) if (g == e + b.bounddata.boundindex == this.selectedrowindex) {
                d = true;
                break;
            }
            return d;
        },
        _isrowselected: function(a, b) {
            var c = false;
            var d = 0;
            if (this.virtualmode && this.pageable && this.groupable) if (this.groups.length > 0) d = this.dataview.pagesize * this.dataview.pagenum;
            if (this.groupable && this.groups.length > 0 && this.pageable) {
                var e = this.getrowboundindexbyid(b.bounddata.uid);
                if (void 0 == e || e == -1) return false;
                if (this.selectedrowindexes.indexOf(e) != -1) c = true;
                if (!c) c = e == this.selectedrowindex && this.selectedrowindex != -1;
                return c;
            }
            if (a && null != b.bounddata) if ("singlerow" != this.selectionmode) {
                if (this.dataview.filters.length > 0) {
                    if (!this.virtualmode && void 0 != b.bounddata.dataindex) {
                        if (this.selectedrowindexes.indexOf(d + b.bounddata.dataindex) != -1) c = true;
                    } else if (this.selectedrowindexes.indexOf(d + b.bounddata.boundindex) != -1) c = true;
                } else if (this.selectedrowindexes.indexOf(d + b.bounddata.boundindex) != -1) c = true;
            } else if (this.dataview.filters.length > 0) {
                if (!this.virtualmode && void 0 != b.bounddata.dataindex) {
                    if (this.selectedrowindexes.indexOf(d + b.bounddata.dataindex) != -1) c = true;
                } else if (this.selectedrowindexes.indexOf(d + b.bounddata.boundindex) != -1) c = true;
            } else if (d + b.bounddata.boundindex == this.selectedrowindex) c = true;
            return c;
        },
        _rendervisualcell: function(b, c, d, e, f, g, h, i, j, k, l, m) {
            var n = null;
            var o = this.columns.records[k];
            if (o.hidden) {
                var p = i.cells[k];
                p.innerHTML = "";
                return;
            }
            cellvalue = this._getcellvalue(o, j);
            var p = i.cells[k];
            var q = c;
            if (this.selectionmode.indexOf("cell") != -1) {
                if (this.dataview.filters.length > 0) if (this.selectedcells[j.bounddata.dataindex + "_" + o.datafield]) d = true; else d = false; else if (this.selectedcells[j.boundindex + "_" + o.datafield]) d = true; else d = false;
                if (this.editcell) if (this.editcell.row === j.boundindex && this.editcell.column === o.datafield) if ("checkbox" !== o.columntype) d = false;
                if (this.virtualmode || this.groupable && this.groups.length > 0 && this.pageable) d = this._iscellselected(true, j, o.datafield);
            }
            if ("" != o.cellclassname && o.cellclassname) if ("string" == typeof o.cellclassname) q += " " + o.cellclassname; else {
                var r = o.cellclassname(this.getboundindex(j), o.datafield, cellvalue, j.bounddata);
                if (r) q += " " + r;
            }
            var s = this.showsortcolumnbackground && this.sortcolumn && o.displayfield == this.sortcolumn;
            if (s) q += " " + this.toTP("jqx-grid-cell-sort");
            if (o.filter && this.showfiltercolumnbackground) q += " " + this.toTP("jqx-grid-cell-filter");
            if (o.pinned && this.showpinnedcolumnbackground || o.grouped) if (g) q += " " + this.toTP("jqx-grid-cell-pinned"); else q += " " + this.toTP("jqx-grid-cell-pinned");
            if (this.altrows && void 0 == j.group) {
                var t = j.visibleindex;
                if (t >= this.altstart) if ((this.altstart + t) % (1 + this.altstep) == 0) {
                    if (!s) q += " " + this.toTP("jqx-grid-cell-alt"); else q += " " + this.toTP("jqx-grid-cell-sort-alt");
                    if (o.filter && this.showfiltercolumnbackground) q += " " + this.toTP("jqx-grid-cell-filter-alt");
                    if (o.pinned && this.showpinnedcolumnbackground) q += " " + this.toTP("jqx-grid-cell-pinned-alt");
                }
            }
            if (k <= h) {
                if (g || this.rowdetails) {
                    var u = a(p);
                    var v = this.columns.records[k].width;
                    if (p.style.width != parseInt(v) + "px") u.width(v);
                }
            } else if (g || this.rowdetails) if (this._hiddencolumns) {
                var u = a(p);
                var v = this.columns.records[k].width;
                if (parseInt(p.style.width) != v) u.width(v);
            }
            var w = true;
            if (this.rowdetails && e) {
                if (f && !g) q += " " + this.toTP("jqx-grid-details-cell"); else if (g) q += " " + this.toTP("jqx-grid-group-details-cell");
                if (this.showrowdetailscolumn) if (!this.rtl) {
                    if (void 0 == j.group && k == h) {
                        var x = this.toThemeProperty("jqx-icon-arrow-down");
                        if (f) {
                            q += " " + this.toTP("jqx-grid-group-expand");
                            q += " " + x;
                        } else {
                            q += " " + this.toTP("jqx-grid-group-collapse");
                            var x = this.toThemeProperty("jqx-icon-arrow-right");
                            q += " " + x;
                        }
                        w = false;
                        p.title = "";
                        p.innerHTML = "";
                        if (p.className != q) p.className = q;
                        return;
                    }
                } else if (void 0 == j.group && k == i.cells.length - h - 1) {
                    var x = this.toThemeProperty("jqx-icon-arrow-down");
                    if (f) {
                        q += " " + this.toTP("jqx-grid-group-expand-rtl");
                        q += " " + x;
                    } else {
                        q += " " + this.toTP("jqx-grid-group-collapse-rtl");
                        var x = this.toThemeProperty("jqx-icon-arrow-left");
                        q += " " + x;
                    }
                    w = false;
                    p.title = "";
                    p.innerHTML = "";
                    if (p.className != q) p.className = q;
                    return;
                }
            }
            if (d && w && k >= h) {
                q += " " + this.toTP("jqx-grid-cell-selected");
                q += " " + this.toTP("jqx-fill-state-pressed");
            }
            if (p.className != q) p.className = q;
            if (void 0 != j.group) {
                cellvalue = "";
                p.title = "";
                p.innerHTML = "";
                return;
            }
            b(this, o, j, cellvalue, p, m);
        },
        _rendercell: function(b, c, d, e, f, g) {
            var h = e + "_" + c.visibleindex;
            if ("number" == c.columntype || null != c.cellsrenderer) var h = d.uniqueid + "_" + c.visibleindex;
            if ("number" == c.columntype) e = d.visibleindex;
            if (b.editcell && void 0 == b.editrow) if ("selectedrow" == b.editmode && c.editable && b.editable) {
                if (b.editcell.row == b.getboundindex(d)) if (b._showcelleditor) {
                    if (!b.hScrollInstance.isScrolling() && !b.vScrollInstance.isScrolling()) b._showcelleditor(b.editcell.row, c, f, b.editcell.init); else b._showcelleditor(b.editcell.row, c, f, false, false);
                    return;
                }
            } else if (b.editcell.row == b.getboundindex(d) && b.editcell.column == c.datafield) {
                b.editcell.element = f;
                if (b.editcell.editing) if (b._showcelleditor) {
                    if (!b.hScrollInstance.isScrolling() && !b.vScrollInstance.isScrolling()) b._showcelleditor(b.editcell.row, c, b.editcell.element, b.editcell.init); else b._showcelleditor(b.editcell.row, c, b.editcell.element, b.editcell.init, false);
                    return;
                }
            }
            var i = b._defaultcellsrenderer(e, c);
            var j = b._cellscache[h];
            if (j) {
                if ("inline" == c.columntype) {
                    b._renderinlinecell(b, f, c, d, e);
                    if (null != c.cellsrenderer) {
                        var k = c.cellsrenderer(b.getboundindex(d), c.datafield, e, i, c.getcolumnproperties(), d.bounddata);
                        if (void 0 != k) f.innerHTML = k;
                    }
                    return;
                } else if ("checkbox" == c.columntype) {
                    if (b.host.jqxCheckBox) {
                        if ("" === e) e = null;
                        var l = 0 == f.innerHTML.toString().length;
                        if (f.checkbox && !b.groupable && !l) {
                            f.checkboxrow = b.getboundindex(d);
                            if ("" == e) e = false;
                            if ("1" == e) e = true;
                            if ("0" == e) e = false;
                            if (1 == e) e = true;
                            if (0 == e) e = false;
                            if ("true" == e) e = true;
                            if ("false" == e) e = false;
                            if (null == e && !c.threestatecheckbox) e = false;
                            if (c.checkboxcolumn) {
                                e = false;
                                if (b.dataview.filters.length > 0 && !b.virtualmode && void 0 != d.bounddata.dataindex) {
                                    if (b.selectedrowindexes.indexOf(d.bounddata.dataindex) != -1) e = true;
                                } else if (b.selectedrowindexes.indexOf(d.bounddata.boundindex) != -1) e = true;
                            }
                            if (!b.disabled) if (f.checkboxinstance) f.checkboxinstance._setState(e); else f.checkbox.jqxCheckBox("_setState", e);
                        } else b._rendercheckboxcell(b, f, c, d, e);
                        if (null != c.cellsrenderer) {
                            var k = c.cellsrenderer(b.getboundindex(d), c.datafield, e, i, c.getcolumnproperties(), d.bounddata);
                            if (void 0 != k) f.innerHTML = k;
                        }
                        return;
                    }
                } else if ("button" == c.columntype) if (b.host.jqxButton) {
                    if ("" == e) e = false;
                    if (null != c.cellsrenderer) e = c.cellsrenderer(b.getboundindex(d), c.datafield, e, i, c.getcolumnproperties(), d.bounddata);
                    if ("" == f.innerHTML) {
                        f.buttonrow = b.getboundindex(d);
                        f.button = null;
                        b._renderbuttoncell(b, f, c, d, e);
                    }
                    if (f.button && !b.groupable) {
                        f.buttonrow = b.getboundindex(d);
                        f.button.val(e);
                    } else b._renderbuttoncell(b, f, c, d, e);
                    return;
                }
                var m = j.element;
                if (null != c.cellsrenderer || f.childNodes && 0 == f.childNodes.length || b.groupable || b.rowdetails) {
                    if (f.innerHTML != m) f.innerHTML = m;
                } else if (f.innerHTML.indexOf("editor") >= 0) f.innerHTML = m; else if (g) {
                    var n = m.indexOf(">");
                    var o = m.indexOf("</");
                    var p = m.substring(n + 1, o);
                    var q = f.childNodes[0];
                    if (p.indexOf(">") >= 0) f.innerHTML = m; else if (q.childNodes[0]) {
                        if (p != q.childNodes[0].nodeValue) if (p.indexOf("&") >= 0) f.innerHTML = m; else q.childNodes[0].nodeValue = p;
                    } else {
                        var r = document.createTextNode(p);
                        q.appendChild(r);
                    }
                } else if (f.innerHTML != m) f.innerHTML = m;
                if (b.enabletooltips && c.enabletooltips) f.title = j.title;
                return;
            }
            if ("checkbox" == c.columntype) {
                b._rendercheckboxcell(b, f, c, d, e);
                b._cellscache[h] = {
                    element: "",
                    title: e
                };
                if (b.enabletooltips && c.enabletooltips) f.title = e;
                return;
            } else if ("button" == c.columntype) {
                if (null != c.cellsrenderer) e = c.cellsrenderer(b.getboundindex(d), c.datafield, e, i, c.getcolumnproperties(), d.bounddata);
                b._renderbuttoncell(b, f, c, d, e);
                b._cellscache[h] = {
                    element: "",
                    title: e
                };
                if (b.enabletooltips && c.enabletooltips) f.title = e;
                return;
            } else if ("number" == c.columntype) e = d.visibleindex; else if ("inline" == c.columntype) {
                b._renderinlinecell(b, f, c, d, e);
                b._cellscache[h] = {
                    element: "",
                    title: e
                };
                if (b.enabletooltips && c.enabletooltips) f.title = e;
                return;
            }
            var m = null;
            if (null != c.cellsrenderer) m = c.cellsrenderer(b.getboundindex(d), c.datafield, e, i, c.getcolumnproperties(), d.bounddata); else m = i;
            if (null == m) m = i;
            var s = e;
            if (b.enabletooltips && c.enabletooltips) {
                if ("" != c.cellsformat) if (a.jqx.dataFormat) if (a.jqx.dataFormat.isDate(e)) s = a.jqx.dataFormat.formatdate(s, c.cellsformat, this.gridlocalization); else if (a.jqx.dataFormat.isNumber(e)) s = a.jqx.dataFormat.formatnumber(s, c.cellsformat, this.gridlocalization);
                f.title = s;
            }
            if (b.WinJS) a(f).html(m); else f.innerHTML = m;
            b._cellscache[h] = {
                element: f.innerHTML,
                title: s
            };
            return true;
        },
        _isIE10: function() {
            if (void 0 == this._browser) {
                var b = a.jqx.utilities.getBrowser();
                if ("msie" == b.browser && parseInt(b.version) > 9) this._browser = true; else {
                    this._browser = false;
                    if ("msie" == b.browser) {
                        var c = "Browser CodeName: " + navigator.appCodeName;
                        c += "Browser Name: " + navigator.appName;
                        c += "Browser Version: " + navigator.appVersion;
                        c += "Platform: " + navigator.platform;
                        c += "User-agent header: " + navigator.userAgent;
                        if (c.indexOf("Zune 4.7") != -1) this._browser = true;
                    }
                }
            }
            return this._browser;
        },
        _renderinlinecell: function(b, c, d, e, f) {
            var g = a(c);
            c.innerHTML = '<div style="position: absolute;"></div>';
        },
        _rendercheckboxcell: function(b, c, d, e, f) {
            if (b.host.jqxCheckBox) {
                var g = a(c);
                if ("" === f) if (d.threestatecheckbox) f = null; else f = false;
                if ("1" == f) f = true;
                if ("0" == f) f = false;
                if (1 == f) f = true;
                if (0 == f) f = false;
                if ("true" == f) f = true;
                if ("false" == f) f = false;
                if (d.checkboxcolumn) {
                    f = false;
                    var h = this.getboundindex(e);
                    if (this.selectedrowindexes.indexOf(h) != -1) f = true;
                }
                if (0 == g.find(".jqx-checkbox").length) {
                    c.innerHTML = '<div style="position: absolute; top: 50%; left: 50%; margin-top: -7px; margin-left: -10px;"></div>';
                    a(c.firstChild).jqxCheckBox({
                        disabled: b.disabled,
                        _canFocus: false,
                        hasInput: false,
                        hasThreeStates: d.threestatecheckbox,
                        enableContainerClick: false,
                        animationShowDelay: 0,
                        animationHideDelay: 0,
                        locked: true,
                        theme: b.theme,
                        checked: f
                    });
                    if (this.editable && d.editable) a(c.firstChild).jqxCheckBox({
                        locked: false
                    });
                    if (d.checkboxcolumn) a(c.firstChild).jqxCheckBox({
                        locked: false
                    });
                    c.checkbox = a(c.firstChild);
                    c.checkboxinstance = c.checkbox.data().jqxCheckBox.instance;
                    c.checkboxrow = this.getboundindex(e);
                    var i = a.data(c.firstChild, "jqxCheckBox").instance;
                    i.updated = function(e, f, g) {
                        if (b.disabled) {
                            f = g;
                            var h = b.table[0].rows.length;
                            var i = b._getcolumnindex(d.datafield);
                            for (var j = 0; j < h; j++) {
                                var k = b.table[0].rows[j].cells[i].firstChild;
                                if (k) a(k).jqxCheckBox({
                                    disabled: b.disabled
                                });
                            }
                        }
                        if (d.editable && !b.disabled) {
                            var h = b.table[0].rows.length;
                            var i = b._getcolumnindex(d.datafield);
                            if (void 0 == b.editrow) {
                                if (d.cellbeginedit) {
                                    var l = d.cellbeginedit(c.checkboxrow, d.datafield, d.columntype, !f);
                                    if (false == l) {
                                        b.setcellvalue(c.checkboxrow, d.datafield, !f, true);
                                        return;
                                    }
                                }
                                if ("selectedrow" !== b.editmode) for (var j = 0; j < h; j++) {
                                    var k = b.table[0].rows[j].cells[i].firstChild;
                                    if (k) a(k).jqxCheckBox("destroy");
                                }
                                if (b.editcell && false == b.editcell.validated) b.setcellvalue(c.checkboxrow, d.datafield, !f, true); else if ("selectedrow" !== b.editmode || null == b.editcell) {
                                    b._raiseEvent(17, {
                                        rowindex: c.checkboxrow,
                                        datafield: d.datafield,
                                        value: g,
                                        columntype: d.columntype
                                    });
                                    b.setcellvalue(c.checkboxrow, d.datafield, f, true);
                                    b._raiseEvent(18, {
                                        rowindex: c.checkboxrow,
                                        datafield: d.datafield,
                                        oldvalue: g,
                                        value: f,
                                        columntype: d.columntype
                                    });
                                } else b.setcellvalue(c.checkboxrow, d.datafield, f, false, false);
                            }
                        } else if (d.checkboxcolumn) {
                            if (b.editcell) b.endcelledit(b.editcell.row, b.editcell.column, false, true);
                            if (!b.disabled) {
                                if (f) b.selectrow(c.checkboxrow); else b.unselectrow(c.checkboxrow);
                                if (b.autosavestate) if (b.savestate) b.savestate();
                            }
                        }
                    };
                } else {
                    c.checkboxrow = this.getboundindex(e);
                    a(c.firstChild).jqxCheckBox("_setState", f);
                }
            }
        },
        _renderbuttoncell: function(b, c, d, e, f) {
            if (b.host.jqxButton) {
                var g = a(c);
                if ("" == f) f = false;
                if (0 == g.find(".jqx-button").length) {
                    c.innerHTML = '<input type="button" style="opacity: 0.99; position: absolute; top: 0%; left: 0%; padding: 0px; margin-top: 2px; margin-left: 2px;"/>';
                    a(c.firstChild).val(f);
                    a(c.firstChild).attr("hideFocus", "true");
                    a(c.firstChild).jqxButton({
                        disabled: b.disabled,
                        theme: b.theme,
                        height: b.rowsheight - 4,
                        width: d.width - 4
                    });
                    c.button = a(c.firstChild);
                    c.buttonrow = b.getboundindex(e);
                    var h = this.isTouchDevice();
                    if (h) {
                        var i = a.jqx.mobile.getTouchEventName("touchend");
                        b.addHandler(a(c.firstChild), i, function(a) {
                            if (d.buttonclick) d.buttonclick(c.buttonrow, a);
                        });
                    } else b.addHandler(a(c.firstChild), "click", function(a) {
                        if (d.buttonclick) d.buttonclick(c.buttonrow, a);
                    });
                } else {
                    c.buttonrow = b.getboundindex(e);
                    a(c.firstChild).val(f);
                }
            }
        },
        _clearvisualrow: function(b, c, d, e, f) {
            var g = this.toTP("jqx-grid-cell");
            if (c) g = " " + this.toTP("jqx-grid-group-cell");
            g += " " + this.toTP("jqx-grid-cleared-cell");
            var h = this.table[0].rows;
            for (var i = 0; i < e + f; i++) if (h[d]) {
                var j = h[d].cells[i];
                if (j.className != g) j.className = g;
                var k = this.columns.records[i];
                if (this._horizontalvalue != b && !k.pinned) if (true == this.oldhscroll) {
                    var l = -b;
                    j.style.marginLeft = -b + "px";
                }
                var m = k.width;
                if (m < k.minwidth) m = k.minwidth;
                if (m > k.maxwidth) m = k.maxwidth;
                if (parseInt(j.style.width) != m) if ("auto" != m) a(j)[0].style.width = m + "px"; else a(j)[0].style.width = m;
                if ("" != j.title) j.title = "";
                if ("" != j.innerHTML) j.innerHTML = "";
            }
            if (h[d]) if (parseInt(h[d].style.height) != this.rowsheight) h[d].style.height = parseInt(this.rowsheight) + "px";
        },
        _findgroupstate: function(a) {
            var b = this._findgroup(a);
            if (null == b) return false;
            return b.expanded;
        },
        _findgroup: function(a) {
            var b = null;
            if (this.expandedgroups[a]) return this.expandedgroups[a];
            return b;
        },
        _clearcaches: function() {
            this._columnsbydatafield = new Array();
            this._pagescache = new Array();
            this._pageviews = new Array();
            this._cellscache = new Array();
            this.heights = new Array();
            this.hiddens = new Array();
            this.hiddenboundrows = new Array();
            this.heightboundrows = new Array();
            this.detailboundrows = new Array();
            this.details = new Array();
            this.expandedgroups = new Array();
            this._rowdetailscache = new Array();
            this._rowdetailselementscache = new Array();
            if (a.jqx.dataFormat) a.jqx.dataFormat.cleardatescache();
            this.tableheight = null;
        },
        _getColumnText: function(b) {
            if (void 0 == this._columnsbydatafield) this._columnsbydatafield = new Array();
            if (this._columnsbydatafield[b]) return this._columnsbydatafield[b];
            var c = b;
            var d = null;
            a.each(this.columns.records, function() {
                if (this.datafield == b) {
                    c = this.text;
                    d = this;
                    return false;
                }
            });
            this._columnsbydatafield[b] = {
                label: c,
                column: d
            };
            return this._columnsbydatafield[b];
        },
        _getcolumnbydatafield: function(b) {
            if (void 0 == this.__columnsbydatafield) this.__columnsbydatafield = new Array();
            if (this.__columnsbydatafield[b]) return this.__columnsbydatafield[b];
            var c = b;
            var d = null;
            a.each(this.columns.records, function() {
                if (this.datafield == b || this.displayfield == b) {
                    c = this.text;
                    d = this;
                    return false;
                }
            });
            this.__columnsbydatafield[b] = d;
            return this.__columnsbydatafield[b];
        },
        isscrollingvertically: function() {
            var a = this.vScrollBar.jqxScrollBar("isScrolling");
            return a;
        },
        _renderrowdetails: function(b, c, d, e, f, g) {
            if (void 0 == c) return;
            var h = a(c);
            var i = 0;
            var j = this.rowdetails && this.showrowdetailscolumn ? (1 + this.groups.length) * this.groupindentwidth : this.groups.length * this.groupindentwidth;
            if (this.groupable && this.groups.length > 0) for (var k = 0; k <= f; k++) {
                var l = a(c.cells[k]);
                l[0].innerHTML = "";
                l[0].className = "jqx-grid-details-cell";
            }
            var l = a(c.cells[i]);
            if ("none" == l[0].style.display) {
                var m = c.cells[i];
                var n = 2;
                var o = i;
                while (void 0 != m && "none" == m.style.display && n < 10) {
                    m = c.cells[o + n - 1];
                    n++;
                }
                l = a(m);
            }
            if (this.rtl) for (var p = e; p < f; p++) {
                c.cells[p].innerHTML = "";
                c.cells[p].className = "jqx-grid-details-cell";
            }
            l.css("width", "100%");
            h.height(d.rowdetailsheight);
            l[0].className = b;
            var q = this.getboundindex(d);
            var r = q + "_";
            if (this._rowdetailscache[r]) {
                var s = this._rowdetailscache[r];
                var t = s.html;
                if (this.initrowdetails) {
                    if (this._rowdetailscache[r].element) {
                        var u = this._rowdetailscache[r].element;
                        var v = l.coord();
                        var w = this.gridcontent.coord();
                        var x = parseInt(v.top) - parseInt(w.top);
                        var y = parseInt(v.left) - parseInt(w.left);
                        if (this.rtl) y = 0;
                        a(u).css("top", x);
                        a(u).css("left", y);
                        a(u).css("display", "block");
                        a(u).width(this.host.width() - j);
                        if (this.layoutrowdetails) this.layoutrowdetails(q, u, this.element, this.getrowdata(q));
                    }
                } else l[0].innerHTML = t;
                return;
            }
            l[0].innerHTML = "";
            if (!this.enablerowdetailsindent) j = 0;
            var z = '<div class="jqx-enableselect" role="rowgroup" style="border: none; overflow: hidden; width: 100%; height: 100%; margin-left: ' + j + 'px;">' + d.rowdetails + "</div>";
            if (this.rtl) var z = '<div class="jqx-enableselect" role="rowgroup" style="border: none; overflow: hidden; width: 100%; height: 100%; margin-left: ' + 0 + "px; margin-right: " + j + 'px;">' + d.rowdetails + "</div>";
            this._rowdetailscache[r] = {
                id: c.id,
                html: z
            };
            if (this.initrowdetails) {
                var u = a(z)[0];
                a(this.gridcontent).prepend(a(u));
                a(u).css("position", "absolute");
                a(u).width(this.host.width() - j);
                a(u).height(l.height());
                var v = l.coord();
                a(u).css("z-index", 9999);
                if (this.isTouchDevice()) a(u).css("z-index", 99999);
                a(u).addClass(this.toThemeProperty("jqx-widget-content"));
                var v = l.coord();
                var w = this.gridcontent.coord();
                var x = parseInt(v.top) - parseInt(w.top);
                var y = parseInt(v.left) - parseInt(w.left);
                a(u).css("top", x);
                a(u).css("left", y);
                this.content[0].scrollTop = 0;
                this.content[0].scrollLeft = 0;
                var A = a(a(u).children()[0]);
                if ("" != A[0].id) A[0].id = A[0].id + q;
                this.initrowdetails(q, u, this.element, this.getrowdata(q));
                this._rowdetailscache[r].element = u;
                this._rowdetailselementscache[q] = u;
            } else l[0].innerHTML = z;
        },
        _defaultcellsrenderer: function(b, c) {
            if ("" != c.cellsformat) if (a.jqx.dataFormat) if (a.jqx.dataFormat.isDate(b)) b = a.jqx.dataFormat.formatdate(b, c.cellsformat, this.gridlocalization); else if (a.jqx.dataFormat.isNumber(b)) b = a.jqx.dataFormat.formatnumber(b, c.cellsformat, this.gridlocalization);
            var d = "4px";
            if (25 != this.rowsheight) {
                d = this.rowsheight / 2 - this._cellheight / 2;
                if (d < 0) d = 4;
                d += "px";
            }
            if (this.enableellipsis) {
                if ("center" == c.cellsalign || "middle" == c.cellsalign) return '<div style="text-overflow: ellipsis; overflow: hidden; padding-bottom: 2px; text-align: center; margin-top: ' + d + ';">' + b + "</div>";
                if ("left" == c.cellsalign) return '<div style="overflow: hidden; text-overflow: ellipsis; padding-bottom: 2px; text-align: left; margin-right: 2px; margin-left: 4px; margin-top: ' + d + ';">' + b + "</div>";
                if ("right" == c.cellsalign) return '<div style="overflow: hidden;  text-overflow: ellipsis; padding-bottom: 2px; text-align: right; margin-right: 2px; margin-left: 4px; margin-top: ' + d + ';">' + b + "</div>";
            }
            if ("center" == c.cellsalign || "middle" == c.cellsalign) return '<div style="text-align: center; margin-top: ' + d + ';">' + b + "</div>";
            return '<span style="margin-left: 4px; margin-right: 2px; margin-top: ' + d + "; float: " + c.cellsalign + ';">' + b + "</span>";
        },
        getcelltext: function(b, c) {
            if (null == b || null == c) return null;
            var d = this.getcellvalue(b, c);
            var e = this.getcolumn(c);
            if (e && "" != e.cellsformat) if (a.jqx.dataFormat) if (a.jqx.dataFormat.isDate(d)) d = a.jqx.dataFormat.formatdate(d, e.cellsformat, this.gridlocalization); else if (a.jqx.dataFormat.isNumber(d)) d = a.jqx.dataFormat.formatnumber(d, e.cellsformat, this.gridlocalization);
            return d;
        },
        getcelltextbyid: function(b, c) {
            if (null == b || null == c) return null;
            var d = this.getcellvaluebyid(b, c);
            var e = this.getcolumn(c);
            if (e && "" != e.cellsformat) if (a.jqx.dataFormat) if (a.jqx.dataFormat.isDate(d)) d = a.jqx.dataFormat.formatdate(d, e.cellsformat, this.gridlocalization); else if (a.jqx.dataFormat.isNumber(d)) d = a.jqx.dataFormat.formatnumber(d, e.cellsformat, this.gridlocalization);
            return d;
        },
        _getcellvalue: function(a, b) {
            var c = null;
            c = b.bounddata[a.datafield];
            if (null != a.displayfield) c = b.bounddata[a.displayfield];
            if (null == c) c = "";
            return c;
        },
        getcell: function(a, b) {
            if (null == a || null == b) return null;
            var c = parseInt(a);
            var d = a;
            var e = "";
            if (!isNaN(c)) d = this.getrowdata(c);
            if (null != d) e = d[b];
            return this._getcellresult(e, a, b);
        },
        getrenderedcell: function(a, b) {
            if (null == a || null == b) return null;
            var c = parseInt(a);
            var d = a;
            var e = "";
            if (!isNaN(c)) d = this.getrenderedrowdata(c);
            if (null != d) e = d[b];
            return this._getcellresult(e, a, b);
        },
        _getcellresult: function(a, b, c) {
            var d = this.getcolumn(c);
            if (null == d || void 0 == d) return null;
            var e = d.getcolumnproperties();
            var f = e.hidden;
            var g = e.width;
            var h = e.pinned;
            var i = e.cellsalign;
            var j = e.cellsformat;
            var k = this.getrowheight(b);
            if (false == k) return null;
            return {
                value: a,
                row: b,
                column: c,
                datafield: c,
                width: g,
                height: k,
                hidden: f,
                pinned: h,
                align: i,
                format: j
            };
        },
        setcellvaluebyid: function(a, b, c, d, e) {
            var f = this.getrowboundindexbyid(a);
            return this.setcellvalue(f, b, c, d, e);
        },
        getcellvaluebyid: function(a, b) {
            var c = this.getrowboundindexbyid(a);
            return this.getcellvalue(c, b);
        },
        setcellvalue: function(b, c, d, e, f) {
            if (null == b || null == c) return false;
            var g = parseInt(b);
            var h = g;
            var i = b;
            if (!isNaN(g)) i = this.getrowdata(g);
            var j = false;
            if (this.filterable && this._initfilterpanel && this.dataview.filters.length) j = true;
            if (this.virtualmode) this._pagescache = new Array();
            if (this.sortcache) this.sortcache = {};
            var k = "";
            var l = "";
            if (null != i && i[c] !== d) {
                if (null === i[c] && "" === d) return;
                var m = this._getcolumnbydatafield(c);
                var n = "string";
                var o = this.source.datafields || (this.source._source ? this.source._source.datafields : null);
                if (o) {
                    var p = "";
                    a.each(o, function() {
                        if (this.name == m.displayfield) {
                            if (this.type) p = this.type;
                            return false;
                        }
                    });
                    if (p) n = p;
                    l = i[m.displayfield];
                }
                k = i[c];
                if (!m.nullable || null != d && "" !== d && m.nullable && void 0 === d.label) {
                    if (a.jqx.dataFormat.isNumber(k) || "number" == n || "float" == n || "int" == n || "decimal" == n && "date" != n) {
                        d = new Number(d);
                        d = parseFloat(d);
                        if (isNaN(d)) d = 0;
                    } else if (a.jqx.dataFormat.isDate(k) || "date" == n) if ("" != d) {
                        var q = d;
                        q = new Date(q);
                        if ("Invalid Date" != q && null != q) d = q; else if ("Invalid Date" == q) {
                            q = new Date();
                            d = q;
                        }
                    }
                    if (i[c] === d) {
                        if (!this._updating && false != e) this._renderrows(this.virtualsizeinfo);
                        return;
                    }
                }
                var r = this.source && this.source._source.localdata && "observableArray" === this.source._source.localdata.name;
                i[c] = d;
                if (r) {
                    var s = this.source._source.localdata;
                    if (!s._updating) {
                        s._updating = true;
                        s[b][c] = d;
                        s._updating = false;
                    }
                }
                var t = this.getrenderedrowdata(g, true);
                if (!t) return;
                t[c] = d;
                if (null != d && null != d.label) {
                    var m = this._getcolumnbydatafield(c);
                    i[m.displayfield] = d.label;
                    t[m.displayfield] = d.label;
                    i[c] = d.value;
                    t[c] = d.value;
                    if (r && !s._updating) {
                        s._updating = true;
                        s[b][c] = d.value;
                        s[b][m.displayfield] = d.label;
                        s._updating = false;
                    }
                }
                if (j) if (void 0 != i.dataindex) {
                    h = i.dataindex;
                    this.dataview.cachedrecords[i.dataindex][c] = d;
                    if (null != d && void 0 != d.label) {
                        this.dataview.cachedrecords[i.dataindex][c] = d.value;
                        this.dataview.cachedrecords[i.dataindex][m.displayfield] = d.label;
                    }
                }
            } else {
                if (!this._updating && false != e) this._renderrows(this.virtualsizeinfo);
                return false;
            }
            if (this.source && this.source._knockoutdatasource && !this._updateFromAdapter && this.autokoupdates) if (this.source._source._localdata) {
                var u = g;
                if (j) if (void 0 != i.dataindex) u = i.dataindex;
                var v = this.source._source._localdata()[u];
                this.source.suspendKO = true;
                var w = v;
                if (w[c] && w[c].subscribe) if (null != d && null != d.label) {
                    w[m.displayfield](d.label);
                    w[c](d.value);
                } else w[c](d); else {
                    var o = this.source._source.datafields;
                    var x = null;
                    var y = null;
                    if (o) a.each(o, function() {
                        if (this.name == c) {
                            y = this.map;
                            return false;
                        }
                    });
                    if (null == y) if (null != d && null != d.label) {
                        w[c] = d.value;
                        w[m.displayfield] = d.label;
                    } else w[c] = d; else {
                        var z = y.split(this.source.mapChar);
                        if (z.length > 0) {
                            var A = w;
                            for (var B = 0; B < z.length - 1; B++) A = A[z[B]];
                            A[z[z.length - 1]] = d;
                        }
                    }
                    this.source._source._localdata.replace(v, a.extend({}, w));
                }
                this.source.suspendKO = false;
            }
            if (this.sortcolumn && this.dataview.sortby && !this._updating) {
                var C = this.getsortinformation();
                if (this.sortcolumn == c) {
                    this.dataview.clearsortdata();
                    this.dataview.sortby(C.sortcolumn, C.sortdirection.ascending);
                }
            } else if (!this._updating) if (this.dataview.sortby) if (this.dataview.sortcache[c]) this.dataview.sortcache[c] = null;
            this._cellscache = new Array();
            if (this.source.updaterow && (void 0 == f || true == f)) {
                var D = false;
                var E = this.that;
                var F = function(a) {
                    if (false == a) {
                        E.setcellvalue(b, c, k, true, false);
                        if (k != l) E.setcellvalue(b, E.getcolumn(c).displayfield, l, true, false);
                    }
                };
                try {
                    var G = this.getrowid(g);
                    D = this.source.updaterow(G, i, F);
                    if (void 0 == D) D = true;
                } catch (H) {
                    D = false;
                    E.setcellvalue(b, c, k, true, false);
                    if (k != l) E.setcellvalue(b, E.getcolumn(c).displayfield, l, true, false);
                    return;
                }
            }
            var I = this.vScrollInstance.value;
            if (this._updating && true != e) e = false;
            if (true == e || void 0 == e) {
                var E = this.that;
                var J = function() {
                    if (E.pageable && E.updatepagerdetails) {
                        E.updatepagerdetails();
                        if (E.autoheight || E.autorowheight) E._updatepageviews();
                    }
                };
                var K = this.groupable && this.groups.length > 0;
                if (j && !K) {
                    if (this.autoheight || this.autorowheight) this.prerenderrequired = true;
                    this.dataview.refresh();
                    this.rendergridcontent(true, false);
                    J();
                    this._renderrows(this.virtualsizeinfo);
                } else if (this.sortcolumn && !K) {
                    if (this.autoheight || this.autorowheight) this.prerenderrequired = true;
                    this.dataview.reloaddata();
                    this.rendergridcontent(true, false);
                    J();
                    this._renderrows(this.virtualsizeinfo);
                } else if (this.groupable && this.groups.length > 0) {
                    if (this.autoheight || this.autorowheight) this.prerenderrequired = true;
                    if (this.pageable) if (this.groups.indexOf(c) != -1) {
                        this._pagescache = new Array();
                        this._cellscache = new Array();
                        this.dataview.refresh();
                        this._render(true, true, false, false);
                    } else {
                        this._pagescache = new Array();
                        this._cellscache = new Array();
                        this.dataview.updateview();
                        this._renderrows(this.virtualsizeinfo);
                    } else {
                        this._pagescache = new Array();
                        this._cellscache = new Array();
                        this.dataview.updateview();
                        this._renderrows(this.virtualsizeinfo);
                    }
                } else {
                    this.dataview.updateview();
                    this._renderrows(this.virtualsizeinfo);
                }
            }
            this.vScrollInstance.setPosition(I);
            if (this.showaggregates && this._updatecolumnsaggregates) this._updatecolumnsaggregates();
            if (this.showfilterrow && this.filterable && this.filterrow) {
                var L = this.getcolumn(c).filtertype;
                if ("list" == L || "checkedlist" == L) this._updatelistfilters(true);
            }
            this._raiseEvent(19, {
                rowindex: b,
                datafield: c,
                newvalue: d,
                value: d,
                oldvalue: k
            });
            return true;
        },
        getcellvalue: function(a, b) {
            if (null == a || null == b) return null;
            var c = parseInt(a);
            var d = a;
            if (!isNaN(c)) d = this.getrowdata(c);
            if (null != d) {
                var e = d[b];
                return e;
            }
            return null;
        },
        getrows: function() {
            var b = this.dataview.records.length;
            if (this.virtualmode) {
                var c = new Array();
                for (var d = 0; d < this.dataview.records.length; d++) {
                    var e = this.dataview.records[d];
                    if (e) c.push(e);
                }
                if (void 0 === this.dataview.records.length) a.each(this.dataview.records, function() {
                    var a = this;
                    if (a) c.push(a);
                });
                var f = 0;
                if (this.pageable) f = this.dataview.pagenum * this.dataview.pagesize;
                if (c.length > this.source._source.totalrecords - f) return c.slice(0, this.source._source.totalrecords - f);
                return c;
            }
            if (this.dataview.sortdata) {
                var c = new Array();
                for (var d = 0; d < b; d++) {
                    var g = {};
                    g = a.extend({}, this.dataview.sortdata[d].value);
                    c[d] = g;
                }
                return c;
            } else return this.dataview.records;
        },
        getrowboundindexbyid: function(a) {
            var b = this.dataview.recordsbyid["id" + a];
            if (b) if (b.boundindex) return this.getboundindex(b);
            var c = this.getboundrows();
            for (var d = 0; d < c.length; d++) if (c[d]) if (c[d].uid == a) return d;
            return -1;
        },
        getrowdatabyid: function(a) {
            var b = this.dataview.recordsbyid["id" + a];
            if (b) return b; else {
                var c = this.getrowboundindexbyid(a);
                return this.getboundrows()[c];
            }
            return null;
        },
        getrowdata: function(a) {
            if (void 0 == a) a = 0;
            if (this.virtualmode) {
                var b = this.dataview.records[a];
                return b;
            } else {
                var b = this.getboundrows()[a];
                return b;
            }
            return null;
        },
        getrenderedrowdata: function(a, b) {
            if (void 0 == a) a = 0;
            if (this.virtualmode) {
                var c = this.getrowvisibleindex(a);
                var d = this.dataview.loadedrecords[c];
                return d;
            }
            var c = this.getrowvisibleindex(a);
            if (c >= 0) {
                if (this.groupable && this.groups.length > 0) var d = this.dataview.loadedrecords[c]; else {
                    var d = this.dataview.loadedrecords[c];
                    if (this.pageable && (void 0 == b || false == b)) var d = this.dataview.loadedrecords[this.dataview.pagesize * this.dataview.pagenum + a];
                }
                return d;
            }
            return null;
        },
        getboundrows: function() {
            return this.dataview.cachedrecords;
        },
        getrowdisplayindex: function(a) {
            var b = this.getdisplayrows();
            for (var c = 0; c < b.length; c++) if (void 0 !== b[c].dataindex) {
                if (b[c].dataindex === a) return b[c].visibleindex;
            } else if (b[c].boundindex === a) return b[c].visibleindex;
            return -1;
        },
        getboundindex: function(a) {
            var b = a.boundindex;
            if (this.groupable && this.groups.length > 0 && this.pageable) if (a.bounddata) b = this.getrowboundindexbyid(a.bounddata.uid);
            if (this.dataview.filters.length > 0) if (a.bounddata) {
                if (void 0 !== a.bounddata.dataindex) b = a.bounddata.dataindex;
            } else if (void 0 !== a.dataindex) b = a.dataindex;
            return b;
        },
        getrowboundindex: function(a) {
            var b = this.getdisplayrows()[a];
            if (b) {
                if (void 0 !== b.dataindex) return b.dataindex;
                return b.boundindex;
            }
            return -1;
        },
        getdisplayrows: function() {
            return this.dataview.loadedrecords;
        },
        getloadedrows: function() {
            return this.getdisplayrows();
        },
        getvisiblerowdata: function(a) {
            var b = this.getvisiblerows();
            if (b) return b[a];
            return null;
        },
        getloadedrowdata: function(a) {
            var b = this.getloadedrows();
            if (b) return b[a];
            return null;
        },
        getvisiblerows: function() {
            if (this.virtualmode) return this.dataview.loadedrecords;
            if (this.pageable) {
                var a = [];
                for (var b = 0; b < this.dataview.pagesize; b++) {
                    var c = this.dataview.loadedrecords[b + this.dataview.pagesize * this.dataview.pagenum];
                    if (void 0 == c) break;
                    a.push(c);
                }
                return a;
            } else if (void 0 != this._startboundindex && void 0 != this._endboundindex) {
                var a = [];
                for (var b = this._startvisibleindex; b <= this._endvisibleindex; b++) {
                    var c = this.dataview.loadedrecords[b];
                    if (void 0 == c) break;
                    a.push(c);
                }
                return a;
            }
            return this.dataview.loadedrecords;
        },
        getrowid: function(a) {
            if (void 0 == a) a = 0;
            if (this.virtualmode) {
                var b = this.getrowvisibleindex(a);
                var c = this.dataview.loadedrecords[b];
                if (c) return c.uid;
            } else {
                var c = null;
                var d = this.dataview.filters.length > 0;
                if (a >= 0 && a < this.dataview.bounditems.length && !d) {
                    if (this.groupable && this.groups.length > 0) {
                        var b = this.getrowvisibleindex(a);
                        var c = this.dataview.loadedrecords[b];
                    } else {
                        var b = this.getrowvisibleindex(a);
                        var c = this.dataview.loadedrecords[b];
                    }
                    if (c) return c.uid;
                }
                if (this.dataview.filters.length > 0) {
                    var c = this.getboundrows()[a];
                    if (c) if (null != c.uid) return c.uid;
                    return null;
                }
            }
            return null;
        },
        _updateGridData: function(a) {
            var b = false;
            if (this.filterable && this._initfilterpanel && this.dataview.filters.length) b = true;
            if (b) {
                this.dataview.refresh();
                if ("updaterow" == a) {
                    this._render(true, true, false, false, false);
                    this.invalidate();
                } else this.render();
            } else if (this.sortcolumn || this.groupable && this.groups.length > 0) {
                this.dataview.reloaddata();
                this.render();
            } else {
                this._cellscache = new Array();
                this._pagescache = new Array();
                this._renderrows(this.virtualsizeinfo);
            }
            if (this.showfilterrow && this.filterable && this.filterrow) this._updatelistfilters(true);
        },
        updaterow: function(b, c, d) {
            if (void 0 != b && void 0 != c) {
                var e = this.that;
                var f = false;
                e._datachanged = true;
                var g = function(b, c, e) {
                    if (b._loading) {
                        throw new Error("jqxGrid: " + b.loadingerrormessage);
                        return false;
                    }
                    var f = false;
                    if (!a.isArray(c)) f = b.dataview.updaterow(c, e); else {
                        a.each(c, function(a, c) {
                            f = b.dataview.updaterow(this, e[a], false);
                        });
                        b.dataview.refresh();
                    }
                    var g = b.vScrollInstance.value;
                    if (void 0 == d || true == d) if (void 0 == b._updating || false == b._updating) b._updateGridData("updaterow");
                    if (b.showaggregates && b._updatecolumnsaggregates) b._updatecolumnsaggregates();
                    if (b.source && b.source._knockoutdatasource && !b._updateFromAdapter && b.autokoupdates) if (b.source._source._localdata) {
                        var h = b.dataview.recordsbyid["id" + c];
                        var i = b.dataview.records.indexOf(h);
                        var j = b.source._source._localdata()[i];
                        b.source.suspendKO = true;
                        b.source._source._localdata.replace(j, a.extend({}, h));
                        b.source.suspendKO = false;
                    }
                    var k = b.source && b.source._source.localdata && "observableArray" === b.source._source.localdata.name;
                    if (k) if (!b.source._source.localdata._updating) {
                        b.source._source.localdata._updating = true;
                        var l = b.getrowboundindexbyid(c);
                        b.source._source.localdata.set(l, e);
                        b.source._source.localdata._updating = false;
                    }
                    b.vScrollInstance.setPosition(g);
                    return f;
                };
                if (this.source.updaterow) {
                    var h = function(a) {
                        if (true == a || void 0 == a) g(e, b, c); else f = false;
                    };
                    try {
                        f = this.source.updaterow(b, c, h);
                        if (void 0 == f) f = true;
                    } catch (i) {
                        f = false;
                    }
                } else f = g(e, b, c);
                return f;
            }
            return false;
        },
        deleterow: function(b, c) {
            if (void 0 != b) {
                this._datachanged = true;
                var d = false;
                var e = this.that;
                var f = this.getrowboundindexbyid(b);
                if (void 0 != f) {
                    if (this.selectedrowindexes.indexOf(f) >= 0) this.selectedrowindexes.splice(this.selectedrowindexes.indexOf(f), 1);
                    if (this.selectedrowindex == f) this.selectedrowindex = -1;
                }
                var g = function(b, d) {
                    if (b._loading) {
                        throw new Error("jqxGrid: " + b.loadingerrormessage);
                        return false;
                    }
                    var e = false;
                    var g = b.vScrollInstance.value;
                    if (!a.isArray(d)) var e = b.dataview.deleterow(d); else {
                        a.each(d, function() {
                            e = b.dataview.deleterow(this, false);
                        });
                        b.dataview.refresh();
                    }
                    if (void 0 == b._updating || false == b._updating) if (void 0 == c || true == c) {
                        b._render(true, true, false, false);
                        if ("visible" != b.vScrollBar.css("visibility")) {
                            b._arrange();
                            b._updatecolumnwidths();
                            b._updatecellwidths();
                            b._renderrows(b.virtualsizeinfo);
                        }
                    }
                    if (b.source && b.source._knockoutdatasource && !b._updateFromAdapter && b.autokoupdates) if (b.source._source._localdata) {
                        b.source.suspendKO = true;
                        b.source._source._localdata.pop(rowdata);
                        b.source.suspendKO = false;
                    }
                    var h = b.source && b.source._source.localdata && "observableArray" === b.source._source.localdata.name;
                    if (h) if (!b.source._source.localdata._updating) {
                        b.source._source.localdata._updating = true;
                        b.source._source.localdata.splice(f, 1);
                        b.source._source.localdata._updating = false;
                    }
                    if (b.dataview.sortby) {
                        var i = b.getsortinformation();
                        b.dataview.clearsortdata();
                        b.dataview.sortby(i.sortcolumn, i.sortdirection ? i.sortdirection.ascending : null);
                    }
                    b.vScrollInstance.setPosition(g);
                    return e;
                };
                if (this.source.deleterow) {
                    var h = function(a) {
                        if (true == a || void 0 == a) g(e, b);
                    };
                    try {
                        this.source.deleterow(b, h);
                        if (void 0 == d) d = true;
                    } catch (i) {
                        d = false;
                    }
                } else d = g(e, b);
                return d;
            }
            return false;
        },
        addrow: function(b, c, d) {
            if (void 0 != c) {
                this._datachanged = true;
                if (void 0 == d) d = "last";
                var e = false;
                var f = this.that;
                if (null == b) {
                    var g = this.dataview.filters && this.dataview.filters.length > 0;
                    var h = !g ? this.dataview.totalrecords : this.dataview.cachedrecords.length;
                    if (!a.isArray(c)) {
                        b = this.dataview.getid(this.dataview.source.id, c, h);
                        while (null != this.dataview.recordsbyid["id" + b]) b++;
                    } else {
                        var i = new Array();
                        a.each(c, function(a, b) {
                            var d = f.dataview.getid(f.dataview.source.id, c[a], h + a);
                            i.push(d);
                        });
                        b = i;
                    }
                }
                var j = function(b, c, d, e) {
                    if (b._loading) {
                        throw new Error("jqxGrid: " + b.loadingerrormessage);
                        return false;
                    }
                    var f = b.vScrollInstance.value;
                    var g = false;
                    if (!a.isArray(d)) {
                        if (void 0 != d && void 0 != d.dataindex) delete d.dataindex;
                        g = b.dataview.addrow(c, d, e);
                    } else {
                        a.each(d, function(a, d) {
                            if (void 0 != this.dataindex) delete this.dataindex;
                            var f = null;
                            if (null != c && null != c[a]) f = c[a];
                            g = b.dataview.addrow(f, this, e, false);
                        });
                        b.dataview.refresh();
                    }
                    if (void 0 == b._updating || false == b._updating) {
                        b._render(true, true, false, false);
                        b.invalidate();
                    }
                    if (b.source && b.source._knockoutdatasource && !b._updateFromAdapter && b.autokoupdates) if (b.source._source._localdata) {
                        b.source.suspendKO = true;
                        b.source._source._localdata.push(d);
                        b.source.suspendKO = false;
                    }
                    var h = b.source && b.source._source.localdata && "observableArray" === b.source._source.localdata.name;
                    if (h) if (!b.source._source.localdata._updating) {
                        b.source._source.localdata._updating = true;
                        var i = b.getrowboundindexbyid(c);
                        b.source._source.localdata.set(i, d);
                        b.source._source.localdata._updating = false;
                    }
                    if ("deferred" != b.scrollmode) b.vScrollInstance.setPosition(f); else b.vScrollInstance.setPosition(0);
                    return g;
                };
                if (this.source.addrow) {
                    var k = function(a, e) {
                        if (true == a || void 0 == a) {
                            if (void 0 != e) b = e;
                            j(f, b, c, d);
                        }
                    };
                    try {
                        e = this.source.addrow(b, c, d, k);
                        if (void 0 == e) e = true;
                    } catch (l) {
                        e = false;
                    }
                    if (false == e) return false;
                } else j(this, b, c, d);
                return e;
            }
            return false;
        },
        _findvisiblerow: function(a, b) {
            if (void 0 == a) a = parseInt(this.vScrollInstance.value);
            var c = 0;
            if (void 0 == b || null == b) b = this.rows.records;
            var d = b.length;
            while (c <= d) {
                mid = parseInt((c + d) / 2);
                var e = b[mid];
                if (void 0 == e) break;
                if (e.top > a && e.top + e.height > a) d = mid - 1; else if (e.top < a && e.top + e.height < a) c = mid + 1; else {
                    return mid;
                    break;
                }
            }
            return -1;
        },
        _updatecellwidths: function() {
            var a = this.virtualsizeinfo;
            if (!a) return;
            var b = this.that;
            if (void 0 == b.gridcontent) return;
            if (void 0 == b.table) b.table = b.gridcontent.find("#contenttable" + b.element.id);
            var c = b.groupable && b.groups.length > 0;
            var d = 0;
            var e = a.visiblerecords;
            if (b.pageable && (b.autoheight || b.autorowheight)) {
                e = b.dataview.pagesize;
                if (b.groupable) {
                    b.dataview.updateview();
                    e = b.dataview.rows.length;
                }
            }
            if (!b.groupable && !b.pageable && (b.autoheight || b.autorowheight)) e = b.dataview.totalrecords;
            if (b.rowdetails) e += b.dataview.pagesize;
            if (!b.columns.records) return;
            var f = b.columns.records.length;
            var g = b.table[0].rows;
            for (var h = 0; h < e; h++) {
                var i = g[h];
                if (!i) break;
                var j = i.cells;
                var k = 0;
                for (var l = 0; l < f; l++) {
                    var m = b.columns.records[l];
                    var n = m.width;
                    var o = j[l];
                    if (parseInt(o.style.left) != k) o.style.left = k + "px";
                    if (parseInt(o.style.width) != n) o.style.width = n + "px";
                    if (!(m.hidden && m.hideable)) k += parseFloat(n); else o.style.display = "none";
                }
                if (0 == d) {
                    b.table.width(parseFloat(k) + 2);
                    d = k;
                }
            }
            if (b.showaggregates && b._updateaggregates) b._updateaggregates();
            if (b.showfilterrow && b.filterable && b._updatefilterrowui) b._updatefilterrowui();
            b._updatescrollbarsafterrowsprerender();
            if (c) b._renderrows(b.virtualsizeinfo);
        },
        _updatescrollbarsafterrowsprerender: function() {
            var a = this.that;
            var b = a.hScrollBar[0].style.visibility;
            var c = 0;
            var d = a.vScrollBar[0].style.visibility;
            if ("visible" == d) c = a.scrollbarsize + 3;
            if (a.scrollbarautoshow) c = 0;
            var e = a.element.style.width;
            if (e.toString().indexOf("%") >= 0) e = a.host.width(); else e = parseInt(e);
            if (parseInt(a.table[0].style.width) - 2 > e - c) {
                if ("visible" != b) {
                    if (!a.autowidth) a.hScrollBar[0].style.visibility = "visible";
                    a._arrange();
                }
                if ("visible" == d) if ("deferred" != a.scrollmode && !a.virtualmode) {
                    if (a.virtualsizeinfo) {
                        var f = a.virtualsizeinfo.virtualheight - a._gettableheight();
                        if (!isNaN(f) && f > 0) if ("hidden" != b) a.vScrollBar.jqxScrollBar("max", f + a.scrollbarsize + 4); else a.vScrollBar.jqxScrollBar("max", f);
                    }
                } else a._updatevscrollbarmax(); else c = -2;
                a.hScrollBar.jqxScrollBar("max", c + a.table.width() - a.host.width());
            } else if ("hidden" != b) {
                a.hScrollBar.css("visibility", "hidden");
                a._arrange();
            }
            a._renderhorizontalscroll();
        },
        _prerenderrows: function(b) {
            var c = this.that;
            if (true == c.prerenderrequired) {
                c.prerenderrequired = false;
                if (c.editable && c._destroyeditors) c._destroyeditors();
                if (void 0 == c.gridcontent) return;
                c.gridcontent.find("#contenttable" + c.element.id).remove();
                if (null != c.table) {
                    c.table.remove();
                    c.table = null;
                }
                c.table = a('<div id="contenttable' + c.element.id + '" style="overflow: hidden; position: relative;" height="100%"></div>');
                c.gridcontent.addClass(c.toTP("jqx-grid-content"));
                c.gridcontent.addClass(c.toTP("jqx-widget-content"));
                c.gridcontent.append(c.table);
                var d = c.groupable && c.groups.length > 0;
                var e = 0;
                c.table[0].rows = new Array();
                var f = c.toTP("jqx-grid-cell");
                if (d) f = " " + c.toTP("jqx-grid-group-cell");
                var g = b.visiblerecords;
                if (c.pageable && (c.autoheight || c.autorowheight)) {
                    g = c.dataview.pagesize;
                    if (c.groupable) {
                        c.dataview.updateview();
                        g = c.dataview.rows.length;
                        if (g < c.dataview.pagesize) g = c.dataview.pagesize;
                    }
                }
                if (!c.pageable && (c.autoheight || c.autorowheight)) g = c.dataview.totalrecords;
                if (c.groupable && c.groups.length > 0 && (c.autoheight || c.autorowheight) && !c.pageable) g = c.dataview.rows.length;
                if (c.rowdetails) if (c.autoheight || c.autorowheight) g += c.dataview.pagesize; else g += g;
                if (!c.columns.records) return;
                var h = c.columns.records.length;
                if (a.jqx.browser.msie && a.jqx.browser.version > 8) c.table.css("opacity", "0.99");
                if (a.jqx.browser.mozilla) ;
                if (navigator.userAgent.indexOf("Safari") != -1) c.table.css("opacity", "0.99");
                var i = a.jqx.browser.msie && a.jqx.browser.version < 8;
                if (i) c.host.attr("hideFocus", "true");
                var j = c.tableZIndex;
                if (g * h > j) j = g * h;
                var k = 0 == c.dataview.records.length;
                var l = c.isTouchDevice();
                var m = "";
                c._hiddencolumns = false;
                for (var n = 0; n < g; n++) {
                    var o = '<div role="row" style="position: relative; height=' + c.rowsheight + 'px;" id="row' + n + c.element.id + '">';
                    if (i) {
                        var o = '<div role="row" style="position: relative; z-index: ' + j + "; height:" + c.rowsheight + 'px;" id="row' + n + c.element.id + '">';
                        j--;
                    }
                    var p = 0;
                    for (var q = 0; q < h; q++) {
                        var r = c.columns.records[q];
                        var s = r.width;
                        if (s < r.minwidth) s = r.minwidth;
                        if (s > r.maxwidth) s = r.maxwidth;
                        if (c.rtl) {
                            var t = j - h + 2 * q;
                            var u = '<div role="gridcell" style="left: ' + p + "px; z-index: " + t + "; width:" + s + "px;";
                            j--;
                        } else var u = '<div role="gridcell" style="left: ' + p + "px; z-index: " + j-- + "; width:" + s + "px;";
                        if (!(r.hidden && r.hideable)) p += s; else {
                            u += "display: none;";
                            c._hiddencolumns = true;
                            j++;
                        }
                        u += '" class="' + f + '"></div>';
                        o += u;
                    }
                    if (0 == e) {
                        c.table.width(parseInt(p) + 2);
                        e = p;
                    }
                    o += "</div>";
                    m += o;
                }
                if (c.WinJS) MSApp.execUnsafeLocalFunction(function() {
                    c.table.html(m);
                }); else c.table[0].innerHTML = m;
                c.table[0].rows = new Array();
                var v = c.table.children();
                for (var n = 0; n < g; n++) {
                    var w = v[n];
                    c.table[0].rows.push(w);
                    w.cells = new Array();
                    var x = a(w).children();
                    for (var q = 0; q < h; q++) w.cells.push(x[q]);
                }
                if (0 == g) {
                    var p = 0;
                    if (c.showemptyrow) {
                        var o = a('<div style="position: relative;" id="row0' + c.element.id + '"></div>');
                        c.table.append(o);
                        o.height(c.rowsheight);
                        c.table[0].rows[0] = o[0];
                        c.table[0].rows[0].cells = new Array();
                    }
                    for (var q = 0; q < h; q++) {
                        var r = c.columns.records[q];
                        var s = r.width;
                        if (c.showemptyrow) {
                            var u = a('<div style="position: absolute; height: 100%; left: ' + p + "px; z-index: " + j-- + "; width:" + s + 'px;" class="' + f + '"></div>');
                            u.height(c.rowsheight);
                            o.append(u);
                            c.table[0].rows[0].cells[q] = u[0];
                        }
                        if (s < r.minwidth) s = r.minwidth;
                        if (s > r.maxwidth) s = r.maxwidth;
                        if (!(r.hidden && r.hideable)) p += s;
                    }
                    c.table.width(parseInt(p) + 2);
                    e = p;
                }
                c._updatescrollbarsafterrowsprerender();
                if (c.rendered) c.rendered("rows");
                c._addoverlayelement();
            }
        },
        _groupsheader: function() {
            return this.groupable && this.showgroupsheader;
        },
        _arrange: function() {
            var a = null;
            var b = null;
            this.tableheight = null;
            var c = this.that;
            var d = false;
            var e = false;
            if (null != c.width && c.width.toString().indexOf("px") != -1) a = c.width; else if (void 0 != c.width && !isNaN(c.width)) a = c.width;
            if (null != c.width && c.width.toString().indexOf("%") != -1) {
                a = c.width;
                d = true;
            }
            if (c.scrollbarautoshow) {
                c.vScrollBar[0].style.display = "none";
                c.hScrollBar[0].style.display = "none";
                c.vScrollBar[0].style.zIndex = c.tableZIndex + c.headerZIndex;
                c.hScrollBar[0].style.zIndex = c.tableZIndex + c.headerZIndex;
            }
            if (c.autowidth) {
                var f = 0;
                for (var g = 0; g < c.columns.records.length; g++) {
                    var h = c.columns.records[g].width;
                    if ("auto" == h) {
                        h = c._measureElementWidth(c.columns.records[g].text);
                        f += h;
                    } else f += h;
                }
                if ("hidden" != c.vScrollBar.css("visibility")) f += c.scrollbarsize + 4;
                a = f;
                c.width = a;
            }
            if (null != c.height && c.height.toString().indexOf("px") != -1) b = c.height; else if (void 0 != c.height && !isNaN(c.height)) b = c.height;
            if (null != c.height && c.height.toString().indexOf("%") != -1) {
                b = c.height;
                e = true;
            }
            var i = function() {
                var a = 0;
                var b = c.showheader ? null != c.columnsheader ? c.columnsheader.height() + 2 : 0 : 0;
                a += b;
                if (c.pageable) a += c.pagerheight;
                if (c._groupsheader()) a += c.groupsheaderheight;
                if (c.showtoolbar) a += c.toolbarheight;
                if (c.showstatusbar) a += c.statusbarheight;
                if ("visible" == c.hScrollBar[0].style.visibility) a += 20;
                return a;
            };
            if (c.autoheight && c.virtualsizeinfo) if (c.pageable && c.gotopage) {
                var j = 0;
                b = j + (c._pageviews[0] ? c._pageviews[0].height : 0);
                b += i();
                if (c.showemptyrow && 0 == c.dataview.totalrecords) b += c.rowsheight;
            } else {
                var j = c.host.height() - c._gettableheight();
                if (c._pageviews.length > 0) {
                    b = j + c._pageviews[c._pageviews.length - 1].height + c._pageviews[c._pageviews.length - 1].top;
                    c.vScrollBar[0].style.visibility = "hidden";
                } else {
                    b = i();
                    if (c.showemptyrow) b += c.rowsheight;
                }
            } else if (c.autoheight) {
                b = c.dataview.totalrecords * c.rowsheight;
                if (c._loading) {
                    b = 250;
                    c.dataloadelement.height(b);
                }
                b += i();
                if (b > 1e4) b = 1e4;
            }
            if (null != a) {
                a = parseInt(a);
                if (!d) {
                    if (c.element.style.width != parseInt(c.width) + "px") c.element.style.width = parseInt(c.width) + "px";
                } else c.element.style.width = c.width;
                if (d) {
                    a = c.host.width();
                    if (a <= 2) {
                        a = 600;
                        c.host.width(a);
                    }
                    if (!c._oldWidth) c._oldWidth = a;
                }
            } else c.host.width(250);
            if (null != b) {
                if (!e) b = parseInt(b);
                if (!e) {
                    if (c.element.style.height != parseInt(b) + "px") c.element.style.height = parseInt(b) + "px";
                } else c.element.style.height = c.height;
                if (e && !c.autoheight) {
                    b = c.host.height();
                    if (0 == b) {
                        b = 400;
                        c.host.height(b);
                    }
                    if (!c._oldHeight) c._oldHeight = b;
                }
            } else c.host.height(250);
            if (c.autoheight) {
                c.tableheight = null;
                c._gettableheight();
            }
            var k = 0;
            if (c.showtoolbar) {
                c.toolbar.width(a);
                c.toolbar.height(c.toolbarheight - 1);
                c.toolbar.css("top", 0);
                k += c.toolbarheight;
                b -= parseInt(c.toolbarheight);
            } else c.toolbar[0].style.height = "0px";
            if (c.showstatusbar) {
                if (c.showaggregates) c.statusbar.width(!c.table ? a : Math.max(a, c.table.width())); else c.statusbar.width(a);
                c.statusbar.height(c.statusbarheight);
            } else c.statusbar[0].style.height = "0px";
            if (c._groupsheader()) {
                c.groupsheader.width(a);
                c.groupsheader.height(c.groupsheaderheight);
                c.groupsheader.css("top", k);
                var l = c.groupsheader.height() + 1;
                k += l;
                if (b > l) b -= parseInt(l);
            } else {
                if (c.groupsheader[0].style.width != a + "px") c.groupsheader[0].style.width = parseInt(a) + "px";
                c.groupsheader[0].style.height = "0px";
                if (c.groupsheader[0].style.top != k + "px") c.groupsheader.css("top", k);
                var l = c.showgroupsheader && c.groupable ? c.groupsheaderheight : 0;
                var m = k + l + "px";
                if (c.content[0].style.top != m) c.content.css("top", k + c.groupsheaderheight);
            }
            var n = c.scrollbarsize;
            if (isNaN(n)) {
                n = parseInt(n);
                if (isNaN(n)) n = "17px"; else n += "px";
            }
            n = parseInt(n);
            var o = 4;
            var p = 2;
            var q = 0;
            if ("visible" == c.vScrollBar[0].style.visibility) q = n + o;
            if ("visible" == c.hScrollBar[0].style.visibility) p = n + o + 2;
            var r = 0;
            if (c.pageable) {
                r = c.pagerheight;
                p += c.pagerheight;
            }
            if (c.showstatusbar) {
                p += c.statusbarheight;
                r += c.statusbarheight;
            }
            if (c.hScrollBar[0].style.height != n + "px") c.hScrollBar[0].style.height = parseInt(n) + "px";
            if (c.hScrollBar[0].style.top != k + b - o - n - r + "px" || "0px" != c.hScrollBar[0].style.left) c.hScrollBar.css({
                top: k + b - o - n - r + "px",
                left: "0px"
            });
            var s = c.hScrollBar[0].style.width;
            var t = false;
            var u = false;
            if (0 == q) {
                if (s != a - 2 + "px") {
                    c.hScrollBar.width(a - 2);
                    t = true;
                }
            } else if (s != a - n - o + "px") {
                c.hScrollBar.width(a - n - o + "px");
                t = true;
            }
            if (!c.autoheight) {
                if (c.vScrollBar[0].style.width != n + "px") {
                    c.vScrollBar.width(n);
                    u = true;
                }
                if (c.vScrollBar[0].style.height != parseInt(b) - p + "px") {
                    c.vScrollBar.height(parseInt(b) - p + "px");
                    u = true;
                }
                if (c.vScrollBar[0].style.left != parseInt(a) - parseInt(n) - o + "px" || c.vScrollBar[0].style.top != k + "px") c.vScrollBar.css({
                    left: parseInt(a) - parseInt(n) - o + "px",
                    top: k
                });
            }
            if (c.rtl) {
                c.vScrollBar.css({
                    left: "0px",
                    top: k
                });
                if ("hidden" != c.vScrollBar.css("visibility")) c.hScrollBar.css({
                    left: n + 2
                });
            }
            var v = c.vScrollInstance;
            v.disabled = c.disabled;
            if (!c.autoheight) if (u) v.refresh();
            var w = c.hScrollInstance;
            w.disabled = c.disabled;
            if (t) w.refresh();
            if (c.autowidth) c.hScrollBar[0].style.visibility = "hidden";
            c.statusbarheight = parseInt(c.statusbarheight);
            c.toolbarheight = parseInt(c.toolbarheight);
            var x = function(a) {
                if ("visible" == a.vScrollBar[0].style.visibility && "visible" == a.hScrollBar[0].style.visibility) {
                    a.bottomRight[0].style.visibility = "visible";
                    a.bottomRight.css({
                        left: 1 + parseInt(a.vScrollBar.css("left")),
                        top: parseInt(a.hScrollBar.css("top"))
                    });
                    if (a.rtl) a.bottomRight.css("left", "0px");
                    a.bottomRight.width(parseInt(n) + 3);
                    a.bottomRight.height(parseInt(n) + 4);
                    if (a.showaggregates) {
                        a.bottomRight.css("z-index", 99);
                        a.bottomRight.height(parseInt(n) + 4 + a.statusbarheight);
                        a.bottomRight.css({
                            top: parseInt(a.hScrollBar.css("top")) - a.statusbarheight
                        });
                    }
                } else a.bottomRight[0].style.visibility = "hidden";
            };
            x(this);
            if (c.content[0].style.width != a - q + "px") c.content.width(a - q);
            if (c.content[0].style.height != b - p + 3 + "px") c.content.height(b - p + 3);
            if (c.scrollbarautoshow) {
                if (c.content[0].style.width != a + "px") c.content.width(a);
                if (c.content[0].style.height != b + "px") c.content.height(b);
            }
            if (c.content[0].style.top != k + "px") c.content.css("top", k);
            if (c.rtl) {
                c.content.css("left", q);
                if (c.scrollbarautoshow) c.content.css("left", "0px");
                if (c.table) {
                    var y = c.table.width();
                    if (y < a - q) c.content.css("left", a - y);
                }
            }
            if (c.showstatusbar) {
                c.statusbar.css("top", k + b - c.statusbarheight - (c.pageable ? c.pagerheight : 0));
                if (c.showaggregates) {
                    if ("visible" == c.hScrollBar.css("visibility")) {
                        c.hScrollBar.css({
                            top: k + b - o - n - r + c.statusbarheight + "px"
                        });
                        c.statusbar.css("top", 1 + k + b - n - 5 - c.statusbarheight - (c.pageable ? c.pagerheight : 0));
                    }
                    x(this);
                }
                if (c.rtl) if ("visible" != c.hScrollBar.css("visibility")) c.statusbar.css("left", c.content.css("left")); else c.statusbar.css("left", "0px");
            }
            if (c.pageable) {
                c.pager.width(a);
                c.pager.height(c.pagerheight);
                c.pager.css("top", k + b - c.pagerheight - 1);
            } else c.pager[0].style.height = "0px";
            if (null != c.table) {
                var z = -2;
                if ("visible" == c.vScrollBar[0].style.visibility) z = c.scrollbarsize + 3;
                if ("visible" == c.hScrollBar[0].style.visibility) {
                    var A = z + c.table.width() - c.host.width();
                    if (A >= 0) c.hScrollBar.jqxScrollBar("max", A);
                    if ("visible" == c.hScrollBar[0].style.visibility && 0 == A) {
                        c.hScrollBar[0].style.visibility = "hidden";
                        c._arrange();
                    }
                }
            }
            if (a != parseInt(c.dataloadelement[0].style.width)) c.dataloadelement[0].style.width = c.element.style.width;
            if (b != parseInt(c.dataloadelement[0].style.height)) c.dataloadelement[0].style.height = c.element.style.height;
            c._hostwidth = a;
        },
        destroy: function() {
            delete a.jqx.dataFormat.datescache;
            delete this.gridlocalization;
            a.jqx.utilities.resize(this.host, null, true);
            if (this.table && this.table[0]) {
                var b = this.table[0].rows.length;
                for (var c = 0; c < b; c++) {
                    var d = this.table[0].rows[c];
                    var e = d.cells;
                    var f = e.length;
                    for (var g = 0; g < f; g++) {
                        a(d.cells[g]).remove();
                        d.cells[g] = null;
                        delete d.cells[g];
                    }
                    d.cells = null;
                    if (d.cells) delete d.cells;
                    a(this.table[0].rows[c]).remove();
                    this.table[0].rows[c] = null;
                }
                try {
                    delete this.table[0].rows;
                } catch (h) {}
                this.table.remove();
                delete this.table;
            }
            if (this.columns && this.columns.records) {
                for (var c = 0; c < this.columns.records.length; c++) {
                    var i = this.columns.records[c];
                    this._removecolumnhandlers(this.columns.records[c]);
                    if (i.element) {
                        a(i.element).remove();
                        a(i.sortasc).remove();
                        a(i.sortdesc).remove();
                        a(i.filtericon).remove();
                        a(i.menu).remove();
                        i.element = null;
                        i.uielement = null;
                        i.sortasc = null;
                        i.sortdesc = null;
                        i.filtericon = null;
                        i.menu = null;
                        delete i.element;
                        delete i.uielement;
                        delete i.sortasc;
                        delete i.sortdesc;
                        delete i.filtericon;
                        delete i.menu;
                        delete this.columnsrow[0].cells[c];
                    }
                }
                try {
                    delete this.columnsrow[0].cells;
                } catch (h) {}
                delete this.columnsrow;
            }
            a.removeData(document.body, "contextmenu" + this.element.id);
            if (this.host.jqxDropDownList) if (this._destroyfilterpanel) this._destroyfilterpanel();
            if (this.editable && this._destroyeditors) this._destroyeditors();
            if (this.filterable && this._destroyedfilters && this.showfilterrow) this._destroyedfilters();
            if (this.host.jqxMenu) if (this.gridmenu) {
                this.removeHandler(a(document), "click.menu" + this.element.id);
                this.removeHandler(this.gridmenu, "keydown");
                this.removeHandler(this.gridmenu, "closed");
                this.removeHandler(this.gridmenu, "itemclick");
                this.gridmenu.jqxMenu("destroy");
                this.gridmenu = null;
            }
            if (this.pagershowrowscombo) {
                this.pagershowrowscombo.jqxDropDownList("destroy");
                this.pagershowrowscombo = null;
            }
            if (this.pagerrightbutton) {
                this.removeHandler(this.pagerrightbutton, "mousedown");
                this.removeHandler(this.pagerrightbutton, "mouseup");
                this.removeHandler(this.pagerrightbutton, "click");
                this.pagerrightbutton.jqxButton("destroy");
                this.pagerrightbutton = null;
            }
            if (this.pagerleftbutton) {
                this.removeHandler(this.pagerleftbutton, "mousedown");
                this.removeHandler(this.pagerleftbutton, "mouseup");
                this.removeHandler(this.pagerleftbutton, "click");
                this.pagerleftbutton.jqxButton("destroy");
                this.removeHandler(a(document), "mouseup.pagerbuttons" + this.element.id);
                this.pagerleftbutton = null;
            }
            this.removeHandler(a(document), "selectstart." + this.element.id);
            this.removeHandler(a(document), "mousedown.resize" + this.element.id);
            this.removeHandler(a(document), "mouseup.resize" + this.element.id);
            this.removeHandler(a(document), "mousemove.resize" + this.element.id);
            if (this.isTouchDevice()) {
                var j = a.jqx.mobile.getTouchEventName("touchmove") + ".resize" + this.element.id;
                var k = a.jqx.mobile.getTouchEventName("touchstart") + ".resize" + this.element.id;
                var l = a.jqx.mobile.getTouchEventName("touchend") + ".resize" + this.element.id;
                this.removeHandler(a(document), j);
                this.removeHandler(a(document), k);
                this.removeHandler(a(document), l);
            }
            this.removeHandler(a(document), "mousedown.reorder" + this.element.id);
            this.removeHandler(a(document), "mouseup.reorder" + this.element.id);
            this.removeHandler(a(document), "mousemove.reorder" + this.element.id);
            if (this.isTouchDevice()) {
                var j = a.jqx.mobile.getTouchEventName("touchmove") + ".reorder" + this.element.id;
                var k = a.jqx.mobile.getTouchEventName("touchstart") + ".reorder" + this.element.id;
                var l = a.jqx.mobile.getTouchEventName("touchend") + ".reorder" + this.element.id;
                this.removeHandler(a(document), j);
                this.removeHandler(a(document), k);
                this.removeHandler(a(document), l);
            }
            this.removeHandler(a(window), "resize." + this.element.id);
            if (this.groupable) {
                var j = "mousemove.grouping" + this.element.id;
                var k = "mousedown.grouping" + this.element.id;
                var l = "mouseup.grouping" + this.element.id;
                this.removeHandler(a(document), j);
                this.removeHandler(a(document), k);
                this.removeHandler(a(document), l);
            }
            if (this.columnsreorder) {
                var j = "mousemove.reorder" + this.element.id;
                var k = "mousedown.reorder" + this.element.id;
                var l = "mouseup.reorder" + this.element.id;
                this.removeHandler(a(document), j);
                this.removeHandler(a(document), k);
                this.removeHandler(a(document), l);
                delete this.columnsbounds;
            }
            if (this.content) {
                this.removeHandler(this.content, "mousedown");
                this.removeHandler(this.content, "scroll");
            }
            this._removeHandlers();
            this.hScrollInstance.destroy();
            this.vScrollInstance.destroy();
            this.hScrollBar.remove();
            this.vScrollBar.remove();
            this._clearcaches();
            delete this.hScrollInstance;
            delete this.vScrollInstance;
            delete this.visiblerows;
            delete this.hittestinfo;
            delete this.rows;
            delete this.columns;
            delete this.columnsbydatafield;
            delete this.pagescache;
            delete this.pageviews;
            delete this.cellscache;
            delete this.heights;
            delete this.hiddens;
            delete this.hiddenboundrows;
            delete this.heightboundrows;
            delete this.detailboundrows;
            delete this.details;
            delete this.expandedgroups;
            delete this._rowdetailscache;
            delete this._rowdetailselementscache;
            delete this.columnsmenu;
            this.columnsheader.remove();
            delete this.columnsheader;
            this.selectionarea.remove();
            delete this.selectionarea;
            if (this.menuitemsarray && this.menuitemsarray.length) {
                var m = this.menuitemsarray.length;
                for (var c = 0; c < m; c++) a(this.menuitemsarray[c]).remove();
            }
            delete this.menuitemsarray;
            this.dataview._clearcaches();
            this.content.removeClass();
            this.content.remove();
            this.content = null;
            delete this.content;
            this.vScrollBar = null;
            this.hScrollBar = null;
            delete this.hScrollBar;
            delete this.hScrollBar;
            this.gridcontent.remove();
            delete this.gridcontent;
            if (this.gridmenu) {
                this.gridmenu = null;
                delete this.gridmenu;
            }
            delete this._mousemovefunc;
            delete this._mousewheelfunc;
            this.dataview.destroy();
            delete this.dataview;
            this.bottomRight.remove();
            delete this.bottomRight;
            this.wrapper.remove();
            delete this.wrapper;
            if (this.pagerdiv) {
                this.pagerdiv.remove();
                delete this.pagerdiv;
            }
            if (this.pagerpageinput) {
                this.pagerpageinput.remove();
                delete this.pagerpageinput;
            }
            if (this.pagergoto) {
                this.pagergoto.remove();
                delete this.pagergoto;
            }
            if (this.pagershowrows) {
                this.pagershowrows.remove();
                delete this.pagershowrows;
            }
            if (this.pagerfirstbutton) {
                this.pagerfirstbutton.remove();
                delete this.pagerfirstbutton;
            }
            if (this.pagerlastbutton) {
                this.pagerlastbutton.remove();
                delete this.pagerlastbutton;
            }
            if (this.pagerbuttons) {
                this.pagerbuttons.remove();
                delete this.pagerbuttons;
            }
            if (this.pagerdetails) {
                this.pagerdetails.remove();
                delete this.pagerdetails;
            }
            if (this.pagergotoinput) {
                this.pagergotoinput.remove();
                delete this.pagergotoinput;
            }
            this.pager.remove();
            delete this.pager;
            this.groupsheader.remove();
            delete this.groupsheader;
            this.dataloadelement.remove();
            delete this.dataloadelement;
            this.toolbar.remove();
            delete this.toolbar;
            this.statusbar.remove();
            delete this.statusbar;
            this.host.removeData();
            this.host.removeClass();
            this.host.remove();
            this.host = null;
            delete this.host;
            delete this.element;
            delete this.set;
            delete this.get;
            delete this.that;
            delete this.call;
        },
        _initializeColumns: function() {
            var c = this.source ? this.source.datafields : null;
            if (null == c && this.source && this.source._source) c = this.source._source.datafields;
            var d = c ? c.length > 0 : false;
            if (this.autogeneratecolumns) {
                var e = new Array();
                if (c) a.each(c, function() {
                    var a = {
                        datafield: this.name,
                        text: this.text || this.name,
                        cellsformat: this.format || ""
                    };
                    e.push(a);
                }); else if (this.source.records.length > 0) {
                    var f = this.source.records[0];
                    for (obj in f) if ("uid" != obj) {
                        var g = {
                            width: 100,
                            datafield: obj,
                            text: obj
                        };
                        e.push(g);
                    }
                }
                this.columns = e;
            }
            if (this.columns && this.columns.records) for (var h = 0; h < this.columns.records.length; h++) this._removecolumnhandlers(this.columns.records[h]);
            var i = this.that;
            var j = new a.jqx.collection(this.element);
            var k = 0;
            this._haspinned = false;
            if (!this._columns) this._columns = this.columns; else this.columns = this._columns;
            if (this.groupable) a.each(this.groups, function(a) {
                var c = new b(i, this);
                c.visibleindex = k++;
                c.width = i.groupindentwidth;
                j.add(c);
                c.grouped = true;
                c.filterable = false;
                c.sortable = false;
                c.editable = false;
                c.resizable = false;
                c.draggable = false;
            });
            if (this.rowdetails && this.showrowdetailscolumn) {
                var g = new b(i, this);
                g.visibleindex = k++;
                g.width = i.groupindentwidth;
                g.pinned = true;
                g.editable = false;
                g.filterable = false;
                g.draggable = false;
                g.groupable = false;
                g.resizable = false;
                j.add(g);
                i._haspinned = true;
            }
            if ("checkbox" == this.selectionmode) {
                var g = new b(i, null);
                g.visibleindex = k++;
                g.width = i.groupindentwidth;
                g.checkboxcolumn = true;
                g.editable = false;
                g.columntype = "checkbox";
                g.groupable = false;
                g.draggable = false;
                g.filterable = false;
                g.resizable = false;
                g.datafield = "_checkboxcolumn";
                j.add(g);
            }
            var l = new Array();
            a.each(this.columns, function(a) {
                if (void 0 != i.columns[a]) {
                    var c = new b(i, this);
                    c.visibleindex = k++;
                    if (void 0 != this.dataField) this.datafield = this.dataField;
                    if (this.pinned) i._haspinned = true;
                    if (null == this.datafield) {
                        if (i.source && i.source._source && "array" == i.source._source.datatype) {
                            if (!d) if (!i.source._source.datafields) {
                                i.source._source.datafields = new Array();
                                i.source._source.datafields.push({
                                    name: a.toString()
                                });
                            } else i.source._source.datafields.push({
                                name: a.toString()
                            });
                            this.datafield = a.toString();
                            this.displayfield = a.toString();
                            c.datafield = this.datafield;
                            c.displayfield = this.displayfield;
                        }
                    } else if (l[this.datafield]) {
                        throw new Error("jqxGrid: Invalid column 'datafield' setting. jqxGrid's columns should be initialized with unique data fields.");
                        i.host.remove();
                        return false;
                    } else l[this.datafield] = true;
                    j.add(c);
                }
            });
            if (this.rtl) j.records.reverse();
            this.columns = j;
        },
        _initializeRows: function() {
            var b = new a.jqx.collection(this.element);
            if (this.rows) this.rows.clear();
            this.rows = b;
        },
        _raiseEvent: function(b, c) {
            if (void 0 == c) c = {
                owner: null
            };
            if (false === this._trigger) return;
            var d = this.events[b];
            if (!this._camelCase) d = d.toLowerCase();
            args = c;
            args.owner = this;
            var e = new a.Event(d);
            e.owner = this;
            e.args = args;
            var f = this.host.trigger(e);
            c = e.args;
            return f;
        },
        wheel: function(a, b) {
            if (b.autoheight && "visible" != b.hScrollBar.css("visibility")) {
                a.returnValue = true;
                return true;
            }
            var c = 0;
            if (!a) a = window.event;
            if (a.originalEvent && a.originalEvent.wheelDelta) a.wheelDelta = a.originalEvent.wheelDelta;
            if (a.wheelDelta) c = a.wheelDelta / 120; else if (a.detail) c = -a.detail / 3;
            if (c) {
                var d = b._handleDelta(c);
                if (d) {
                    if (a.preventDefault) a.preventDefault();
                    if (null != a.originalEvent) a.originalEvent.mouseHandled = true;
                    if (void 0 != a.stopPropagation) a.stopPropagation();
                }
                if (d) {
                    d = false;
                    a.returnValue = d;
                    return d;
                } else return false;
            }
            if (a.preventDefault) a.preventDefault();
            a.returnValue = false;
        },
        _handleDelta: function(a) {
            if ("hidden" != this.vScrollBar.css("visibility")) {
                var b = this.vScrollInstance.value;
                if (a < 0) this.scrollDown(); else this.scrollUp();
                var c = this.vScrollInstance.value;
                if (b != c) return true;
            } else if ("hidden" != this.hScrollBar.css("visibility")) {
                var b = this.hScrollInstance.value;
                if (a > 0) if (this.hScrollInstance.value > 2 * this.horizontalscrollbarstep) this.hScrollInstance.setPosition(this.hScrollInstance.value - 2 * this.horizontalscrollbarstep); else this.hScrollInstance.setPosition(0); else if (this.hScrollInstance.value < this.hScrollInstance.max) this.hScrollInstance.setPosition(this.hScrollInstance.value + 2 * this.horizontalscrollbarstep); else this.hScrollInstance.setPosition(this.hScrollInstance.max);
                var c = this.hScrollInstance.value;
                if (b != c) return true;
            }
            return false;
        },
        scrollDown: function() {
            if ("hidden" == this.vScrollBar.css("visibility")) return;
            var a = this.vScrollInstance;
            if (a.value + this.rowsheight <= a.max) a.setPosition(parseInt(a.value) + this.rowsheight); else a.setPosition(a.max);
        },
        scrollUp: function() {
            if ("hidden" == this.vScrollBar.css("visibility")) return;
            var a = this.vScrollInstance;
            if (a.value - this.rowsheight >= a.min) a.setPosition(parseInt(a.value) - this.rowsheight); else a.setPosition(a.min);
        },
        _removeHandlers: function() {
            var b = this.that;
            b.removeHandler(b.vScrollBar, "valueChanged");
            b.removeHandler(b.hScrollBar, "valueChanged");
            b.vScrollInstance.valueChanged = null;
            b.hScrollInstance.valueChanged = null;
            var c = "mousedown.jqxgrid";
            if (b.isTouchDevice()) c = a.jqx.mobile.getTouchEventName("touchend");
            b.removeHandler(b.host, "dblclick.jqxgrid");
            b.removeHandler(b.host, c);
            b.removeHandler(b.content, "mousemove", b._mousemovefunc);
            b.removeHandler(b.host, "mouseleave.jqxgrid");
            b.removeHandler(b.content, "mouseenter");
            b.removeHandler(b.content, "mouseleave");
            b.removeHandler(b.content, "mousedown");
            b.removeHandler(b.content, "scroll");
            b.removeHandler(b.content, "selectstart." + b.element.id);
            b.removeHandler(b.host, "dragstart." + b.element.id);
            b.removeHandler(b.host, "keydown.edit" + b.element.id);
            b.removeHandler(a(document), "keydown.edit" + b.element.id);
            b.removeHandler(a(document), "keyup.edit" + b.element.id);
            if (b._mousemovedocumentfunc) b.removeHandler(a(document), "mousemove.selection" + b.element.id, b._mousemovedocumentfunc);
            b.removeHandler(a(document), "mouseup.selection" + b.element.id);
            if (b._mousewheelfunc) b.removeHandler(b.host, "mousewheel", b._mousewheelfunc);
            if (b.editable) b.removeHandler(a(document), "mousedown.gridedit" + b.element.id);
            if (b.host.off) {
                b.content.off("mousemove");
                b.host.off("mousewheel");
            }
        },
        _addHandlers: function() {
            var b = this.that;
            var c = b.isTouchDevice();
            if (!c) b.addHandler(b.host, "dragstart." + b.element.id, function(a) {
                return false;
            });
            if (b.scrollbarautoshow) {
                b.addHandler(b.host, "mouseenter.gridscroll" + b.element.id, function(a) {
                    b.vScrollBar.fadeIn("fast");
                    b.hScrollBar.fadeIn("fast");
                });
                b.addHandler(b.host, "mouseleave.gridscroll" + b.element.id, function(a) {
                    if (!b.vScrollInstance.isScrolling() && !b.hScrollInstance.isScrolling()) {
                        b.vScrollBar.fadeOut("fast");
                        b.hScrollBar.fadeOut("fast");
                    }
                });
            }
            if (b.editable) b.addHandler(a(document), "mousedown.gridedit" + b.element.id, function(a) {
                if (b.editable && b.begincelledit) if (b.editcell) if (!b.vScrollInstance.isScrolling() && !b.vScrollInstance.isScrolling()) {
                    var c = b.host.coord();
                    var d = b.host.width();
                    var e = b.host.height();
                    var f = false;
                    var g = false;
                    var h = false;
                    if (a.pageY < c.top || a.pageY > c.top + e) {
                        f = true;
                        g = true;
                    }
                    if (a.pageX < c.left || a.pageX > c.left + d) {
                        f = true;
                        h = true;
                    }
                    if (f) {
                        var i = false;
                        if (b.editcell && b.editcell.editor) switch (b.editcell.columntype) {
                            case "datetimeinput":
                                if (b.editcell.editor.jqxDateTimeInput && b.editcell.editor.jqxDateTimeInput("container") && "block" == b.editcell.editor.jqxDateTimeInput("container")[0].style.display) {
                                    var j = b.editcell.editor.jqxDateTimeInput("container").coord().top;
                                    var k = b.editcell.editor.jqxDateTimeInput("container").coord().top + b.editcell.editor.jqxDateTimeInput("container").height();
                                    if (g && (a.pageY < j || a.pageY > k)) {
                                        f = true;
                                        b.editcell.editor.jqxDateTimeInput("close");
                                    } else return;
                                }
                                break;

                            case "combobox":
                                if (b.editcell.editor.jqxComboBox && b.editcell.editor.jqxComboBox("container") && "block" == b.editcell.editor.jqxComboBox("container")[0].style.display) {
                                    var j = b.editcell.editor.jqxComboBox("container").coord().top;
                                    var k = b.editcell.editor.jqxComboBox("container").coord().top + b.editcell.editor.jqxComboBox("container").height();
                                    if (g && (a.pageY < j || a.pageY > k)) {
                                        f = true;
                                        b.editcell.editor.jqxComboBox("close");
                                    } else return;
                                }
                                break;

                            case "dropdownlist":
                                if (b.editcell.editor.jqxDropDownList && b.editcell.editor.jqxDropDownList("container") && "block" == b.editcell.editor.jqxDropDownList("container")[0].style.display) {
                                    var j = b.editcell.editor.jqxDropDownList("container").coord().top;
                                    var k = b.editcell.editor.jqxDropDownList("container").coord().top + b.editcell.editor.jqxDropDownList("container").height();
                                    if (g && (a.pageY < j || a.pageY > k)) {
                                        f = true;
                                        b.editcell.editor.jqxDropDownList("close");
                                    } else return;
                                }
                                break;

                            case "template":
                            case "custom":
                                var l = [ "jqxDropDownList", "jqxComboBox", "jqxDropDownButton", "jqxDateTimeInput" ];
                                var m = function(c) {
                                    var d = b.editcell.editor.data();
                                    if (d[c] && d[c].instance.container && "block" == d[c].instance.container[0].style.display) {
                                        var e = d[c].instance;
                                        var h = e.container.coord().top;
                                        var i = e.container.coord().top + e.container.height();
                                        if (g && (a.pageY < h || a.pageY > i)) {
                                            f = true;
                                            e.close();
                                            return true;
                                        } else return false;
                                    }
                                };
                                for (var n = 0; n < l.length; n++) {
                                    var o = m(l[n]);
                                    if (false == o) return;
                                }
                        }
                        b.endcelledit(b.editcell.row, b.editcell.column, false, true);
                        b._oldselectedcell = null;
                    }
                }
            });
            b.vScrollInstance.valueChanged = function(a) {
                if (b.virtualsizeinfo) {
                    b._closemenu();
                    if ("physical" != b.scrollmode) {
                        b._renderrows(b.virtualsizeinfo);
                        b.currentScrollValue = a.currentValue;
                    } else if (void 0 != b.currentScrollValue && Math.abs(b.currentScrollValue - a.currentValue) >= 5) {
                        b._renderrows(b.virtualsizeinfo);
                        b.currentScrollValue = a.currentValue;
                    } else {
                        b._renderrows(b.virtualsizeinfo);
                        b.currentScrollValue = a.currentValue;
                    }
                    if (!b.pageable && !b.groupable && b.dataview.virtualmode) {
                        if (b.loadondemandupdate) clearTimeout(b.loadondemandupdate);
                        b.loadondemandupdate = setTimeout(function() {
                            b.loadondemand = true;
                            b._renderrows(b.virtualsizeinfo);
                        }, 100);
                    }
                    if (c) b._lastScroll = new Date();
                }
            };
            b.hScrollInstance.valueChanged = function(d) {
                if (b.virtualsizeinfo) {
                    b._closemenu();
                    var e = function() {
                        b._renderhorizontalscroll();
                        b._renderrows(b.virtualsizeinfo);
                        if (b.editcell && !b.editrow) if (b._showcelleditor && b.editcell.editing) if (!b.hScrollInstance.isScrolling()) b._showcelleditor(b.editcell.row, b.getcolumn(b.editcell.column), b.editcell.element, b.editcell.init);
                    };
                    var f = void 0 == b._browser ? b._isIE10() : b._browser;
                    if (navigator && navigator.userAgent.indexOf("Safari") != -1) {
                        if (b._hScrollTimer) clearTimeout(b._hScrollTimer);
                        b._hScrollTimer = setTimeout(function() {
                            e();
                        }, 1);
                    } else if (a.jqx.browser.msie) {
                        if (b._hScrollTimer) clearTimeout(b._hScrollTimer);
                        b._hScrollTimer = setTimeout(function() {
                            e();
                        }, .01);
                    } else e();
                    if (c) b._lastScroll = new Date();
                }
            };
            b._mousewheelfunc = b._mousewheelfunc || function(a) {
                    if (!b.editcell && b.enablemousewheel) {
                        b.wheel(a, b);
                        return false;
                    }
                };
            b.removeHandler(b.host, "mousewheel", b._mousewheelfunc);
            b.addHandler(b.host, "mousewheel", b._mousewheelfunc);
            var d = "mousedown.jqxgrid";
            if (c) d = a.jqx.mobile.getTouchEventName("touchend");
            b.addHandler(b.host, d, function(c) {
                if (b.isTouchDevice()) {
                    b._newScroll = new Date();
                    if (b._newScroll - b._lastScroll < 500) return false;
                    if (a(c.target).ischildof(b.vScrollBar)) return false;
                    if (a(c.target).ischildof(b.hScrollBar)) return false;
                }
                b._mousedown = new Date();
                var d = b._handlemousedown(c, b);
                if (b.isNestedGrid) if (!b.resizablecolumn && !b.columnsreorder) c.stopPropagation();
                b._lastmousedown = new Date();
                return d;
            });
            if (!c) {
                b.addHandler(b.host, "dblclick.jqxgrid", function(c) {
                    if (b.editable && b.begincelledit && "dblclick" == b.editmode) b._handledblclick(c, b); else if (a.jqx.browser.msie && a.jqx.browser.version < 9) var d = b._handlemousedown(c, b);
                    b.mousecaptured = false;
                    b._lastmousedown = new Date();
                    return true;
                });
                b._mousemovefunc = function(a) {
                    if (b._handlemousemove) return b._handlemousemove(a, b);
                };
                b.addHandler(b.content, "mousemove", b._mousemovefunc);
                if (b._handlemousemoveselection) {
                    b._mousemovedocumentfunc = function(a) {
                        if (b._handlemousemoveselection) return b._handlemousemoveselection(a, b);
                    };
                    b.addHandler(a(document), "mousemove.selection" + b.element.id, b._mousemovedocumentfunc);
                }
                b.addHandler(a(document), "mouseup.selection" + b.element.id, function(a) {
                    if (b._handlemouseupselection) b._handlemouseupselection(a, b);
                });
            }
            try {
                if ("" != document.referrer || window.frameElement) if (null != window.top && window.top != window.self) {
                    var e = null;
                    if (window.parent && document.referrer) e = document.referrer;
                    if (e && e.indexOf(document.location.host) != -1) {
                        var f = function(a) {
                            if (b._handlemouseupselection) try {
                                b._handlemouseupselection(a, b);
                            } catch (c) {}
                        };
                        if (window.top.document.addEventListener) window.top.document.addEventListener("mouseup", f, false); else if (window.top.document.attachEvent) window.top.document.attachEvent("onmouseup", f);
                    }
                }
            } catch (g) {}
            b.focused = false;
            if (!c) {
                b.addHandler(b.content, "mouseenter", function(a) {
                    b.focused = true;
                    if (b.wrapper) {
                        b.wrapper.attr("tabindex", 1);
                        b.content.attr("tabindex", 2);
                    }
                    if (b._overlayElement) if (b.vScrollInstance.isScrolling() || b.hScrollInstance.isScrolling()) b._overlayElement[0].style.visibility = "visible"; else b._overlayElement[0].style.visibility = "hidden";
                });
                b.addHandler(b.content, "mouseleave", function(a) {
                    if (b._handlemousemove) if (b.enablehover) b._clearhoverstyle();
                    if (b._overlayElement) b._overlayElement[0].style.visibility = "hidden";
                    b.focused = false;
                });
                if (b.groupable || b.columnsreorder) b.addHandler(a(document), "selectstart." + b.element.id, function(a) {
                    if (true === b.__drag) return false;
                });
                b.addHandler(b.content, "selectstart." + b.element.id, function(c) {
                    if (b.enablebrowserselection) return true;
                    if (b.showfilterrow) if (a(c.target).ischildof(b.filterrow)) return true;
                    if (!b.editcell) return false;
                    if (c.stopPropagation) c.stopPropagation();
                });
                b.addHandler(a(document), "keyup.edit" + b.element.id, function(a) {
                    b._keydown = false;
                });
                b.addHandler(a(document), "keydown.edit" + b.element.id, function(c) {
                    b._keydown = true && !b.editcell;
                    var d = c.charCode ? c.charCode : c.keyCode ? c.keyCode : 0;
                    if (b.handlekeyboardnavigation) {
                        var e = b.handlekeyboardnavigation(c);
                        if (true == e) return false;
                    }
                    if (b.editable && b.editcell) if (13 == d || 27 == d) if (b._handleeditkeydown) f = b._handleeditkeydown(c, b);
                    if (27 == d) {
                        b.mousecaptured = false;
                        if ("visible" == b.selectionarea.css("visibility")) b.selectionarea.css("visibility", "hidden");
                    }
                    if (a.jqx.browser.msie && a.jqx.browser.version < 8 && b.focused && !b.isNestedGrid) {
                        if (13 == d && false == f) return f;
                        var f = true;
                        var d = c.charCode ? c.charCode : c.keyCode ? c.keyCode : 0;
                        if (!b.editcell && b.editable && "programmatic" != b.editmode) if (b._handleeditkeydown) f = b._handleeditkeydown(c, b);
                        if (f && b.keyboardnavigation && b._handlekeydown) {
                            f = b._handlekeydown(c, b);
                            if (!f) {
                                if (c.preventDefault) c.preventDefault();
                                if (void 0 != c.stopPropagation) c.stopPropagation();
                            }
                            return f;
                        }
                    }
                    return true;
                });
                b.addHandler(b.host, "keydown.edit" + b.element.id, function(c) {
                    var d = true;
                    if (b.handlekeyboardnavigation) {
                        var e = b.handlekeyboardnavigation(c);
                        if (true == e) return false;
                    }
                    if (b.editable && "programmatic" != b.editmode) if (b._handleeditkeydown) {
                        d = b._handleeditkeydown(c, b);
                        if (b.isNestedGrid) c.stopPropagation();
                    }
                    if (!(a.jqx.browser.msie && a.jqx.browser.version < 8)) {
                        if (d && b.keyboardnavigation && b._handlekeydown) {
                            d = b._handlekeydown(c, b);
                            if (b.isNestedGrid) c.stopPropagation();
                        }
                    } else if (b.isNestedGrid) if (d && b.keyboardnavigation && b._handlekeydown) {
                        d = b._handlekeydown(c, b);
                        c.stopPropagation();
                    }
                    if (!d) {
                        if (c.preventDefault) c.preventDefault();
                        if (void 0 != c.stopPropagation) c.stopPropagation();
                    }
                    return d;
                });
            }
        },
        _hittestrow: function(b, c) {
            if (null == this.vScrollInstance || null == this.hScrollInstance) return;
            if (void 0 == b) b = 0;
            if (void 0 == c) ;
            var d = this.vScrollInstance;
            var e = this.hScrollInstance;
            var f = d.value;
            if ("visible" != this.vScrollBar.css("visibility")) f = 0;
            var g = e.value;
            if ("visible" != this.hScrollBar.css("visibility")) g = 0;
            if ("deferred" == this.scrollmode && null != this._newmax) if (f > this._newmax) f = this._newmax;
            var h = parseInt(f) + c;
            var i = parseInt(g) + b;
            if (null == this.visiblerows) return;
            if (0 == this.visiblerows.length) return;
            var j = false;
            var k = this._findvisiblerow(h, this.visiblerows);
            if (k >= 0) {
                var l = this.visiblerows[k];
                var m = this.rowdetails && l.rowdetails;
                var n = !l.rowdetailshidden;
                if (m) {
                    var o = this.visiblerows[k - 1];
                    if (o == l) {
                        l = o;
                        k--;
                    }
                    if (n) {
                        var p = a(this.hittestinfo[k].visualrow).position().top + parseInt(this.table.css("top"));
                        var q = a(this.hittestinfo[k].visualrow).height();
                        if (!(c >= p && c <= p + q)) {
                            k++;
                            l = this.visiblerows[k];
                            j = true;
                        }
                    }
                }
            }
            return {
                index: k,
                row: l,
                details: j
            };
        },
        getcellatposition: function(b, c) {
            var d = this.that;
            var e = this.showheader ? this.columnsheader.height() + 2 : 0;
            var f = this._groupsheader() ? this.groupsheader.height() : 0;
            var g = this.showtoolbar ? this.toolbarheight : 0;
            f += g;
            var h = this.host.coord();
            if (this.hasTransform) h = a.jqx.utilities.getOffset(this.host);
            var i = b - h.left;
            var j = c - e - h.top - f;
            var k = this._hittestrow(i, j);
            var l = k.row;
            var m = k.index;
            var n = this.table[0].rows[m];
            if (this.dataview && 0 == this.dataview.records.length) {
                var o = this.table[0].rows;
                var p = 0;
                for (var q = 0; q < o.length; q++) {
                    if (j >= p && j < p + this.rowsheight) {
                        n = o[q];
                        break;
                    }
                    p += this.rowsheight;
                }
                l = {
                    boundindex: q
                };
            }
            if (null == n) return true;
            var r = this.hScrollInstance;
            var s = r.value;
            var t = 0;
            var u = this.groupable ? this.groups.length : 0;
            for (var q = 0; q < n.cells.length; q++) {
                var v = parseInt(a(this.columnsrow[0].cells[q]).css("left"));
                var b = v - s;
                if (d.columns.records[q].pinned) b = v;
                if (d.columns.records[q].hidden) continue;
                var w = b + a(this.columnsrow[0].cells[q]).width();
                if (w >= i && i >= b) {
                    t = q;
                    break;
                }
            }
            if (null != l) {
                var x = this._getcolumnat(t);
                return {
                    row: this.getboundindex(l),
                    column: x.datafield,
                    value: this.getcellvalue(this.getboundindex(l), x.datafield)
                };
            }
            return null;
        },
        _handlemousedown: function(b, c) {
            if (null == b.target) return true;
            if (c.disabled) return true;
            if (a(b.target).ischildof(this.columnsheader)) return true;
            var d;
            if (b.which) d = 3 == b.which; else if (b.button) d = 2 == b.button;
            var e;
            if (b.which) e = 2 == b.which; else if (b.button) e = 1 == b.button;
            if (e) return true;
            if (this.showstatusbar) {
                if (a(b.target).ischildof(this.statusbar)) return true;
                if (b.target == this.statusbar[0]) return true;
            }
            if (this.showtoolbar) {
                if (a(b.target).ischildof(this.toolbar)) return true;
                if (b.target == this.toolbar[0]) return true;
            }
            if (this.pageable) {
                if (a(b.target).ischildof(this.pager)) return true;
                if (b.target == this.pager[0]) return true;
            }
            if (!this.columnsheader) return true;
            if (!this.editcell) if (this.pageable) if (a(b.target).ischildof(this.pager)) return true;
            var f = this.showheader ? this.columnsheader.height() + 2 : 0;
            var g = this._groupsheader() ? this.groupsheader.height() : 0;
            var h = this.showtoolbar ? this.toolbarheight : 0;
            g += h;
            var i = this.host.coord();
            if (this.hasTransform) {
                i = a.jqx.utilities.getOffset(this.host);
                var j = this._getBodyOffset();
                i.left -= j.left;
                i.top -= j.top;
            }
            var k = parseInt(b.pageX);
            var l = parseInt(b.pageY);
            if (this.isTouchDevice()) {
                var m = c.getTouches(b);
                var n = m[0];
                k = parseInt(n.pageX);
                l = parseInt(n.pageY);
                if (true == c.touchmode) if (void 0 != n._pageX) {
                    k = parseInt(n._pageX);
                    l = parseInt(n._pageY);
                }
            }
            var o = k - i.left;
            var p = l - f - i.top - g;
            if (this.pageable && !this.autoheight && this.gotopage) {
                var q = this.pager.coord().top - i.top - g - f;
                if (p > q) return;
            }
            var r = this._hittestrow(o, p);
            if (!r) return;
            if (r.details) return;
            var s = r.row;
            var t = r.index;
            var u = b.target.className;
            var v = this.table[0].rows[t];
            if (null == v) {
                if (c.editable && c.begincelledit) if (c.editcell) c.endcelledit(c.editcell.row, c.editcell.column, false, true);
                return true;
            }
            c.mousecaptured = true;
            c.mousecaptureposition = {
                left: b.pageX,
                top: b.pageY - g,
                clickedrow: v
            };
            var w = this.hScrollInstance;
            var x = w.value;
            if (this.rtl) if ("hidden" != this.hScrollBar.css("visibility")) x = w.max - w.value;
            var y = -1;
            var z = this.groupable ? this.groups.length : 0;
            if (this.rtl) {
                if ("hidden" != this.vScrollBar[0].style.visibility) x -= this.scrollbarsize + 4;
                if ("hidden" == this.hScrollBar[0].style.visibility) x = -parseInt(this.content.css("left"));
            }
            for (var A = 0; A < v.cells.length; A++) {
                var B = parseInt(a(this.columnsrow[0].cells[A]).css("left"));
                var k = B - x;
                if (c.columns.records[A].pinned && !c.rtl) k = B;
                var C = this._getcolumnat(A);
                if (null != C && C.hidden) continue;
                var D = k + a(this.columnsrow[0].cells[A]).width();
                if (D >= o && o >= k) {
                    y = A;
                    c.mousecaptureposition.clickedcell = A;
                    break;
                }
            }
            if (this.rtl && this._haspinned) for (var A = v.cells.length - 1; A >= 0; A--) {
                if (!c.columns.records[A].pinned) break;
                var B = a(this.columnsrow[0].cells[A]).coord().left - this.host.coord().left;
                var k = B;
                var C = this._getcolumnat(A);
                if (null != C && C.hidden) continue;
                var D = k + a(this.columnsrow[0].cells[A]).width();
                if (D >= o && o >= k) {
                    y = A;
                    c.mousecaptureposition.clickedcell = A;
                    break;
                }
            }
            if (null != s && y >= 0) {
                this._raiseEvent(1, {
                    rowindex: this.getboundindex(s),
                    visibleindex: s.visibleindex,
                    row: s,
                    group: s.group,
                    rightclick: d,
                    originalEvent: b
                });
                var C = this._getcolumnat(y);
                var E = this.getcellvalue(this.getboundindex(s), C.datafield);
                if (this.editable && this.editcell) if (C.datafield == this.editcell.column) if (this.getboundindex(s) == this.editcell.row) this.mousecaptured = false;
                this._raiseEvent(8, {
                    rowindex: this.getboundindex(s),
                    column: C ? C.getcolumnproperties() : null,
                    row: s,
                    visibleindex: s.visibleindex,
                    datafield: C ? C.datafield : null,
                    columnindex: y,
                    value: E,
                    rightclick: d,
                    originalEvent: b
                });
                if (this.isTouchDevice()) if ("checkbox" == C.columntype && this.editable && this._overlayElement) {
                    if (!this.editcell) {
                        this._overlayElement.css("visibility", "hidden");
                        this.editcell = this.getcell(t, C.datafield);
                        return true;
                    }
                } else if ("button" == C.columntype && this._overlayElement) {
                    if (C.buttonclick) C.buttonclick(v.cells[y].buttonrow, b);
                    return true;
                }
                var F = false;
                if (null != this._lastmousedown) if (this._mousedown - this._lastmousedown < 300) if (this._clickedrowindex == this.getboundindex(s)) {
                    this._raiseEvent(22, {
                        rowindex: this.getboundindex(s),
                        row: s,
                        visibleindex: s.visibleindex,
                        group: s.group,
                        rightclick: d,
                        originalEvent: b
                    });
                    if (this._clickedcolumn == C.datafield) this._raiseEvent(23, {
                        rowindex: this.getboundindex(s),
                        row: s,
                        visibleindex: s.visibleindex,
                        column: C ? C.getcolumnproperties() : null,
                        datafield: C ? C.datafield : null,
                        columnindex: y,
                        value: E,
                        rightclick: d,
                        originalEvent: b
                    });
                    F = true;
                    this._clickedrowindex = -1;
                    this._clickedcolumn = null;
                    if (b.isPropagationStopped && b.isPropagationStopped()) return false;
                }
                if (d) return true;
                if (!F) {
                    this._clickedrowindex = this.getboundindex(s);
                    this._clickedcolumn = C.datafield;
                }
                var G = a.jqx.utilities.getBrowser();
                if ("msie" == G.browser && parseInt(G.version) <= 7) {
                    if (0 == y && this.rowdetails) u = "jqx-grid-group-collapse";
                    if (z > 0) if (y <= z) u = "jqx-grid-group-collapse";
                }
                if (u.indexOf("jqx-grid-group-expand") != -1 || u.indexOf("jqx-grid-group-collapse") != -1) {
                    if (!this.rtl) {
                        if (z > 0 && y < z && this._togglegroupstate) this._togglegroupstate(s.bounddata, true); else if (y == z && this.rowdetails && this.showrowdetailscolumn) {
                            this._togglerowdetails(s.bounddata, true);
                            this.gridcontent[0].scrollTop = 0;
                            this.gridcontent[0].scrollLeft = 0;
                        }
                    } else if (z > 0 && y > v.cells.length - z - 1 && this._togglegroupstate) this._togglegroupstate(s.bounddata, true); else if (y == v.cells.length - 1 - z && this.rowdetails && this.showrowdetailscolumn) {
                        this._togglerowdetails(s.bounddata, true);
                        this.gridcontent[0].scrollTop = 0;
                        this.gridcontent[0].scrollLeft = 0;
                    }
                } else if (s.boundindex != -1) {
                    var H = this.selectedrowindexes.slice(0);
                    var I = false;
                    if ("none" != c.selectionmode && "checkbox" != c.selectionmode && this._selectrowwithmouse) {
                        if ("multiplecellsadvanced" == c.selectionmode || "multiplecellsextended" == c.selectionmode || "multiplerowsextended" == c.selectionmode || "multiplerowsadvanced" == c.selectionmode) if (!b.ctrlKey && !b.shiftKey && !b.metaKey) {
                            c.selectedrowindexes = new Array();
                            c.selectedcells = new Array();
                        }
                        var J = false;
                        var K = this.getboundindex(s);
                        if (c._oldselectedrow === K || "none" === c.selectionmode) J = true;
                        if (c.selectionmode.indexOf("cell") == -1) {
                            if ("singlerow" != c.selectionmode || c.selectedrowindex != K && "singlerow" == c.selectionmode) {
                                this._applyrowselection(K, true, false, null, C.datafield);
                                this._selectrowwithmouse(c, r, H, C.datafield, b.ctrlKey || b.metaKey, b.shiftKey);
                            }
                        } else if (null != C.datafield) {
                            this._selectrowwithmouse(c, r, H, C.datafield, b.ctrlKey || b.metaKey, b.shiftKey);
                            if (!b.shiftKey) this._applycellselection(K, C.datafield, true, false);
                        }
                        if (c._oldselectedcell) if (c._oldselectedcell.datafield == c.selectedcell.datafield && c._oldselectedcell.rowindex == c.selectedcell.rowindex) I = true;
                        c._oldselectedcell = c.selectedcell;
                        c._oldselectedrow = K;
                    }
                    if (c.autosavestate) if (c.savestate) c.savestate();
                    if (c.editable && c.begincelledit && "programmatic" != c.editmode) {
                        if (b.isPropagationStopped && b.isPropagationStopped()) return false;
                        if ("selectedrow" == c.editmode) {
                            if (J && !c.editcell) {
                                if ("checkbox" !== C.columntype) var L = c.beginrowedit(this.getboundindex(s));
                            } else if (c.editcell && !J && "none" != c.selectionmode) var L = c.endrowedit(c.editcell.row);
                        } else {
                            var M = "click" == c.editmode || I && "selectedcell" == c.editmode;
                            if (c.selectionmode.indexOf("cell") == -1) if ("dblclick" != c.editmode) M = true;
                            if (M) if (void 0 != s.boundindex && C.editable) {
                                var L = c.begincelledit(this.getboundindex(s), C.datafield, C.defaulteditorvalue);
                                if (c.selectionmode.indexOf("cell") != -1) c._applycellselection(K, C.datafield, false, false);
                            }
                            if (c.selectionmode.indexOf("cell") != -1) if ("selectedcell" == c.editmode && !I && c.editcell) c.endcelledit(c.editcell.row, c.editcell.column, false, true);
                        }
                        return true;
                    }
                }
            }
            return true;
        },
        _columnPropertyChanged: function(a, b, c, d) {},
        _rowPropertyChanged: function(a, b, c, d) {},
        _serializeObject: function(b) {
            if (null == b) return "";
            var c = "";
            a.each(b, function(a) {
                var b = this;
                if (a > 0) c += ", ";
                c += "[";
                var d = 0;
                for (obj in b) {
                    if (d > 0) c += ", ";
                    c += "{" + obj + ":" + b[obj] + "}";
                    d++;
                }
                c += "]";
            });
            return c;
        },
        propertyChangedHandler: function(b, c, d, e) {
            if (void 0 == this.isInitialized || false == this.isInitialized) return;
            c = c.toLowerCase();
            switch (c) {
                case "enablebrowserselection":
                    if (!b.showfilterrow) {
                        if (!b.showstatusbar && !b.showtoolbar) b.host.addClass("jqx-disableselect");
                        b.content.addClass("jqx-disableselect");
                    }
                    if (b.enablebrowserselection) {
                        b.content.removeClass("jqx-disableselect");
                        b.host.removeClass("jqx-disableselect");
                    }
                    break;

                case "columnsheight":
                    if (25 != b.columnsheight || b.columngroups) b._measureElement("column");
                    b._render(true, true, true, false, false);
                    break;

                case "rowsheight":
                    if (e != d) {
                        if (25 != b.rowsheight) b._measureElement("cell");
                        b.virtualsizeinfo = null;
                        b.rendergridcontent(true, false);
                        b.refresh();
                    }
                    break;

                case "scrollMode":
                    b.vScrollInstance.thumbStep = b.rowsheight;
                    break;

                case "showdefaultloadelement":
                    b._builddataloadelement();
                    break;

                case "showfiltermenuitems":
                case "showsortmenuitems":
                case "showgroupmenuitems":
                case "filtermode":
                    b._initmenu();
                    break;

                case "touchmode":
                    if (d != e) {
                        b._removeHandlers();
                        b.touchDevice = null;
                        b.vScrollBar.jqxScrollBar({
                            touchMode: e
                        });
                        b.hScrollBar.jqxScrollBar({
                            touchMode: e
                        });
                        b._updateTouchScrolling();
                        b._arrange();
                        b._updatecolumnwidths();
                        b._updatecellwidths();
                        b._addHandlers();
                    }
                    break;

                case "autoshowcolumnsmenubutton":
                    if (d != e) b._rendercolumnheaders();
                    break;

                case "rendergridrows":
                    if (d != e) b.updatebounddata();
                    break;

                case "editmode":
                    if (d != e) {
                        b._removeHandlers();
                        b._addHandlers();
                    }
                    break;

                case "source":
                    b.updatebounddata();
                    if (b.virtualmode && !b._loading) {
                        b.loadondemand = true;
                        b._renderrows(b.virtualsizeinfo);
                    }
                    break;

                case "horizontalscrollbarstep":
                case "verticalscrollbarstep":
                case "horizontalscrollbarlargestep":
                case "verticalscrollbarlargestep":
                    this.vScrollBar.jqxScrollBar({
                        step: this.verticalscrollbarstep,
                        largestep: this.verticalscrollbarlargestep
                    });
                    this.hScrollBar.jqxScrollBar({
                        step: this.horizontalscrollbarstep,
                        largestep: this.horizontalscrollbarlargestep
                    });
                    break;

                case "closeablegroups":
                    if (b._initgroupsheader) b._initgroupsheader();
                    break;

                case "showgroupsheader":
                    if (d != e) {
                        b._arrange();
                        if (b._initgroupsheader) b._initgroupsheader();
                        b._renderrows(b.virtualsizeinfo);
                    }
                    break;

                case "theme":
                    if (e != d) {
                        a.jqx.utilities.setTheme(d, e, b.host);
                        if (b.gridmenu) b.gridmenu.jqxMenu({
                            theme: e
                        });
                        if (b.pageable) b._updatepagertheme();
                        if (b.filterable) b._updatefilterrowui(true);
                    }
                    break;

                case "showtoolbar":
                case "toolbarheight":
                    if (d != e) {
                        b._arrange();
                        b.refresh();
                    }
                    break;

                case "showstatusbar":
                    if (d != e) {
                        if (b.statusbar) if (e) b.statusbar.show(); else b.statusbar.hide();
                        b._arrange();
                        b.refresh();
                    }
                    break;

                case "statusbarheight":
                    if (d != e) {
                        b._arrange();
                        b.refresh();
                    }
                    break;

                case "filterable":
                case "showfilterrow":
                    if (d != e) b.render();
                    break;

                case "autoshowfiltericon":
                case "showfiltercolumnbackground":
                case "showpinnedcolumnbackground":
                case "showsortcolumnbackground":
                    if (d != e) b.rendergridcontent();
                    break;

                case "showrowdetailscolumn":
                    if (d != e) b.render();
                    break;

                case "scrollbarsize":
                    if (d != e) b._arrange();
                    break;

                case "width":
                case "height":
                    if (d != e) {
                        b._updatesize(true, true);
                        b._resizeWindow();
                        if (b.virtualmode && !b._loading) b.vScrollInstance.setPosition(0);
                    }
                    break;

                case "altrows":
                case "altstart":
                case "altstep":
                    if (d != e) b._renderrows(b.virtualsizeinfo);
                    break;

                case "groupsheaderheight":
                    if (d != e) {
                        b._arrange();
                        if (b._initgroupsheader) b._initgroupsheader();
                    }
                    break;

                case "pagerheight":
                    if (d != e) b._initpager();
                    break;

                case "selectedrowindex":
                    b.selectrow(e);
                    break;

                case "selectionmode":
                    if (d != e) {
                        if ("none" == e) {
                            b.selectedrowindexes = new Array();
                            b.selectedcells = new Array();
                            b.selectedrowindex = -1;
                        }
                        b._renderrows(b.virtualsizeinfo);
                        if ("checkbox" == e) b._render(false, false, true, false, false);
                    }
                    break;

                case "showheader":
                    if (e) b.columnsheader.css("display", "block"); else b.columnsheader.css("display", "none");
                    break;

                case "virtualmode":
                    if (d != e) {
                        b.dataview.virtualmode = b.virtualmode;
                        b.dataview.refresh(false);
                        b._render(false, false, false);
                    }
                    break;

                case "columnsmenu":
                    if (d != e) b.render();
                    break;

                case "columngroups":
                    b._render(true, true, true, false, false);
                    break;

                case "columns":
                    if (b._serializeObject(b._cachedcolumns) !== b._serializeObject(e)) {
                        var f = false;
                        if (b.filterable) if (d && d.records) a.each(d.records, function() {
                            if (this.filter) f = true;
                            b.dataview.removefilter(this.displayfield, this.filter);
                        });
                        b._columns = null;
                        b._filterrowcache = [];
                        b.render();
                        if (f) b.applyfilters();
                        b._cachedcolumns = b.columns;
                        if (b.removesort) b.removesort();
                    } else b._initializeColumns();
                    break;

                case "autoheight":
                    if (d != e) b._render(false, false, true);
                    break;

                case "pagermode":
                case "pagerbuttonscount":
                    if (d != e) if (b._initpager) {
                        if (b.pagershowrowscombo) {
                            b.pagershowrowscombo.jqxDropDownList("destroy");
                            b.pagershowrowscombo = null;
                        }
                        if (b.pagerrightbutton) {
                            b.removeHandler(b.pagerrightbutton, "mousedown");
                            b.removeHandler(b.pagerrightbutton, "mouseup");
                            b.removeHandler(b.pagerrightbutton, "click");
                            b.pagerrightbutton.jqxButton("destroy");
                            b.pagerrightbutton = null;
                        }
                        if (b.pagerleftbutton) {
                            b.removeHandler(b.pagerleftbutton, "mousedown");
                            b.removeHandler(b.pagerleftbutton, "mouseup");
                            b.removeHandler(b.pagerleftbutton, "click");
                            b.pagerleftbutton.jqxButton("destroy");
                            b.removeHandler(a(document), "mouseup.pagerbuttons" + b.element.id);
                            b.pagerleftbutton = null;
                        }
                        b.pagerdiv.remove();
                        b._initpager();
                    }
                    break;

                case "pagesizeoptions":
                case "pageable":
                case "pagesize":
                    if (d != e) {
                        if (b._loading) {
                            throw new Error("jqxGrid: " + b.loadingerrormessage);
                            return;
                        }
                        if (!b.host.jqxDropDownList || !b.host.jqxListBox) {
                            b._testmodules();
                            return;
                        }
                        if (b._initpager) {
                            if ("pageable" != c && "pagermode" != c) if ("string" == typeof e) {
                                var g = "The expected value type is: Int.";
                                if ("pagesize" != c) var g = "The expected value type is: Array of Int values.";
                                throw new Error("Invalid Value for: " + c + ". " + g);
                            }
                            b.dataview.pageable = b.pageable;
                            b.dataview.pagenum = 0;
                            b.dataview.pagesize = b._getpagesize();
                            if (b.virtualmode) b.updatebounddata();
                            b.dataview.refresh(true);
                            b._initpager();
                            if ("pagesizeoptions" == c) if (null != e && e.length > 0) {
                                b.pagesize = parseInt(e[0]);
                                b.dataview.pagesize = parseInt(e[0]);
                                b.prerenderrequired = true;
                                b._requiresupdate = true;
                                b.dataview.pagenum = -1;
                                b.gotopage(0);
                            }
                        }
                        b._render(false, false, false);
                    }
                    break;

                case "groups":
                    if (b._serializeObject(d) !== b._serializeObject(e)) {
                        b.dataview.groups = e;
                        b._refreshdataview();
                        b._render(true, true, true, false);
                    }
                    break;

                case "groupable":
                    if (d != e) {
                        b.dataview.groupable = b.groupable;
                        b.dataview.pagenum = 0;
                        b.dataview.refresh(false);
                        b._render(false, false, true);
                    }
                    break;

                case "renderstatusbar":
                    if (null != e) b.renderstatusbar(b.statusbar);
                    break;

                case "rendertoolbar":
                    if (null != e) b.rendertoolbar(b.toolbar);
                    break;

                case "disabled":
                    if (e) b.host.addClass(b.toThemeProperty("jqx-fill-state-disabled")); else b.host.removeClass(b.toThemeProperty("jqx-fill-state-disabled"));
                    a.jqx.aria(b, "aria-disabled", b.disabled);
                    if (b.pageable) {
                        if (b.pagerrightbutton) {
                            b.pagerrightbutton.jqxButton({
                                disabled: e
                            });
                            b.pagerleftbutton.jqxButton({
                                disabled: e
                            });
                            b.pagershowrowscombo.jqxDropDownList({
                                disabled: e
                            });
                            b.pagergotoinput.attr("disabled", e);
                        }
                        if (b.pagerfirstbutton) {
                            b.pagerfirstbutton.jqxButton({
                                disabled: e
                            });
                            b.pagerlastbutton.jqxButton({
                                disabled: e
                            });
                        }
                    }
                    b.vScrollBar.jqxScrollBar({
                        disabled: e
                    });
                    b.hScrollBar.jqxScrollBar({
                        disabled: e
                    });
                    if (b.filterable && b.showfilterrow) b._updatefilterrowui(true);
            }
        }
    });
    function b(b, c) {
        this.owner = b;
        this.datafield = null;
        this.displayfield = null;
        this.text = "";
        this.sortable = true;
        this.hideable = true;
        this.editable = true;
        this.hidden = false;
        this.groupable = true;
        this.renderer = null;
        this.cellsrenderer = null;
        this.checkchange = null, this.threestatecheckbox = false;
        this.buttonclick = null, this.columntype = null;
        this.cellsformat = "";
        this.align = "left";
        this.cellsalign = "left";
        this.width = "auto";
        this.minwidth = 25;
        this.maxwidth = "auto";
        this.pinned = false;
        this.visibleindex = -1;
        this.filterable = true;
        this.filter = null;
        this.filteritems = [];
        this.resizable = true;
        this.initeditor = null;
        this.createeditor = null;
        this.destroyeditor = null;
        this.geteditorvalue = null;
        this.validation = null;
        this.classname = "";
        this.cellclassname = "";
        this.cellendedit = null;
        this.cellbeginedit = null;
        this.cellvaluechanging = null;
        this.aggregates = null;
        this.aggregatesrenderer = null;
        this.menu = true;
        this.createfilterwidget = null;
        this.filtertype = "default";
        this.filtercondition = null;
        this.rendered = null;
        this.exportable = true;
        this.exporting = false;
        this.draggable = true;
        this.nullable = true;
        this.enabletooltips = true;
        this.columngroup = null;
        this.filterdelay = 800;
        this.getcolumnproperties = function() {
            return {
                nullable: this.nullable,
                sortable: this.sortable,
                hideable: this.hideable,
                hidden: this.hidden,
                groupable: this.groupable,
                width: this.width,
                align: this.align,
                editable: this.editable,
                minwidth: this.minwidth,
                maxwidth: this.maxwidth,
                resizable: this.resizable,
                datafield: this.datafield,
                text: this.text,
                exportable: this.exportable,
                cellsalign: this.cellsalign,
                pinned: this.pinned,
                cellsformat: this.cellsformat,
                columntype: this.columntype,
                classname: this.classname,
                cellclassname: this.cellclassname,
                menu: this.menu
            };
        }, this.setproperty = function(a, b) {
            if (this[a]) {
                var c = this[a];
                this[a] = b;
                this.owner._columnPropertyChanged(this, a, b, c);
            } else if (this[a.toLowerCase()]) {
                var c = this[a.toLowerCase()];
                this[a.toLowerCase()] = b;
                this.owner._columnPropertyChanged(this, a.toLowerCase(), b, c);
            }
        };
        this._initfields = function(c) {
            if (null != c) {
                var d = this.that;
                if (a.jqx.hasProperty(c, "dataField")) this.datafield = a.jqx.get(c, "dataField");
                if (a.jqx.hasProperty(c, "displayField")) this.displayfield = a.jqx.get(c, "displayField"); else this.displayfield = this.datafield;
                if (a.jqx.hasProperty(c, "enableTooltips")) this.enabletooltips = a.jqx.get(c, "enableTooltips");
                if (a.jqx.hasProperty(c, "text")) this.text = a.jqx.get(c, "text"); else this.text = this.displayfield;
                if (a.jqx.hasProperty(c, "sortable")) this.sortable = a.jqx.get(c, "sortable");
                if (a.jqx.hasProperty(c, "hideable")) this.hideable = a.jqx.get(c, "hideable");
                if (a.jqx.hasProperty(c, "hidden")) this.hidden = a.jqx.get(c, "hidden");
                if (a.jqx.hasProperty(c, "groupable")) this.groupable = a.jqx.get(c, "groupable");
                if (a.jqx.hasProperty(c, "renderer")) this.renderer = a.jqx.get(c, "renderer");
                if (a.jqx.hasProperty(c, "align")) this.align = a.jqx.get(c, "align");
                if (a.jqx.hasProperty(c, "cellsAlign")) this.cellsalign = a.jqx.get(c, "cellsAlign");
                if (a.jqx.hasProperty(c, "cellsFormat")) this.cellsformat = a.jqx.get(c, "cellsFormat");
                if (a.jqx.hasProperty(c, "width")) this.width = a.jqx.get(c, "width");
                if (a.jqx.hasProperty(c, "minWidth")) this.minwidth = a.jqx.get(c, "minWidth");
                if (a.jqx.hasProperty(c, "maxWidth")) this.maxwidth = a.jqx.get(c, "maxWidth");
                if (a.jqx.hasProperty(c, "cellsRenderer")) this.cellsrenderer = a.jqx.get(c, "cellsRenderer");
                if (a.jqx.hasProperty(c, "columnType")) this.columntype = a.jqx.get(c, "columnType");
                if (a.jqx.hasProperty(c, "checkChange")) this.checkchange = a.jqx.get(c, "checkChange");
                if (a.jqx.hasProperty(c, "buttonClick")) this.buttonclick = a.jqx.get(c, "buttonClick");
                if (a.jqx.hasProperty(c, "pinned")) this.pinned = a.jqx.get(c, "pinned");
                if (a.jqx.hasProperty(c, "visibleIndex")) this.visibleindex = a.jqx.get(c, "visibleIndex");
                if (a.jqx.hasProperty(c, "filterable")) this.filterable = a.jqx.get(c, "filterable");
                if (a.jqx.hasProperty(c, "filter")) this.filter = a.jqx.get(c, "filter");
                if (a.jqx.hasProperty(c, "resizable")) this.resizable = a.jqx.get(c, "resizable");
                if (a.jqx.hasProperty(c, "editable")) this.editable = a.jqx.get(c, "editable");
                if (a.jqx.hasProperty(c, "initEditor")) this.initeditor = a.jqx.get(c, "initEditor");
                if (a.jqx.hasProperty(c, "createEditor")) this.createeditor = a.jqx.get(c, "createEditor");
                if (a.jqx.hasProperty(c, "destroyEditor")) this.destroyeditor = a.jqx.get(c, "destroyEditor");
                if (a.jqx.hasProperty(c, "getEditorValue")) this.geteditorvalue = a.jqx.get(c, "getEditorValue");
                if (a.jqx.hasProperty(c, "validation")) this.validation = a.jqx.get(c, "validation");
                if (a.jqx.hasProperty(c, "cellBeginEdit")) this.cellbeginedit = a.jqx.get(c, "cellBeginEdit");
                if (a.jqx.hasProperty(c, "cellEndEdit")) this.cellendedit = a.jqx.get(c, "cellEndEdit");
                if (a.jqx.hasProperty(c, "className")) this.classname = a.jqx.get(c, "className");
                if (a.jqx.hasProperty(c, "cellClassName")) this.cellclassname = a.jqx.get(c, "cellClassName");
                if (a.jqx.hasProperty(c, "menu")) this.menu = a.jqx.get(c, "menu");
                if (a.jqx.hasProperty(c, "aggregates")) this.aggregates = a.jqx.get(c, "aggregates");
                if (a.jqx.hasProperty(c, "aggregatesRenderer")) this.aggregatesrenderer = a.jqx.get(c, "aggregatesRenderer");
                if (a.jqx.hasProperty(c, "createFilterWidget")) this.createfilterwidget = a.jqx.get(c, "createFilterWidget");
                if (a.jqx.hasProperty(c, "filterType")) this.filtertype = a.jqx.get(c, "filterType");
                if (a.jqx.hasProperty(c, "filterDelay")) this.filterdelay = a.jqx.get(c, "filterDelay");
                if (a.jqx.hasProperty(c, "rendered")) this.rendered = a.jqx.get(c, "rendered");
                if (a.jqx.hasProperty(c, "exportable")) this.exportable = a.jqx.get(c, "exportable");
                if (a.jqx.hasProperty(c, "filterItems")) this.filteritems = a.jqx.get(c, "filterItems");
                if (a.jqx.hasProperty(c, "cellValueChanging")) this.cellvaluechanging = a.jqx.get(c, "cellValueChanging");
                if (a.jqx.hasProperty(c, "draggable")) this.draggable = a.jqx.get(c, "draggable");
                if (a.jqx.hasProperty(c, "filterCondition")) this.filtercondition = a.jqx.get(c, "filterCondition");
                if (a.jqx.hasProperty(c, "threeStateCheckbox")) this.threestatecheckbox = a.jqx.get(c, "threeStateCheckbox");
                if (a.jqx.hasProperty(c, "nullable")) this.nullable = a.jqx.get(c, "nullable");
                if (a.jqx.hasProperty(c, "columnGroup")) this.columngroup = a.jqx.get(c, "columnGroup");
                if (!c instanceof String && !("string" == typeof c)) for (var e in c) if (!d.hasOwnProperty(e)) if (!d.hasOwnProperty(e.toLowerCase())) {
                    b.host.remove();
                    throw new Error("jqxGrid: Invalid property name - " + e + ".");
                }
            }
        };
        this._initfields(c);
        return this;
    }
    function c(a, b) {
        this.setdata = function(a) {
            if (null != a) {
                this.bounddata = a;
                this.boundindex = a.boundindex;
                this.visibleindex = a.visibleindex;
                this.group = a.group;
                this.parentbounddata = a.parentItem;
                this.uniqueid = a.uniqueid;
                this.level = a.level;
            }
        };
        this.setdata(b);
        this.parentrow = null;
        this.subrows = new Array();
        this.owner = a;
        this.height = 25;
        this.hidden = false;
        this.rowdetails = null;
        this.rowdetailsheight = 100;
        this.rowdetailshidden = true;
        this.top = -1;
        this.setrowinfo = function(a) {
            this.hidden = a.hidden;
            this.rowdetails = a.rowdetails;
            this.rowdetailsheight = a.rowdetailsheight;
            this.rowdetailshidden = !a.showdetails;
            this.height = a.height;
        };
        return this;
    }
    a.jqx.collection = function(a) {
        this.records = new Array();
        this.owner = a;
        this.updating = false;
        this.beginupdate = function() {
            this.updating = true;
        };
        this.resumeupdate = function() {
            this.updating = false;
        };
        this._raiseEvent = function(a) {};
        this.clear = function() {
            this.records = new Array();
        };
        this.replace = function(a, b) {
            this.records[a] = b;
            if (!this.updating) this._raiseEvent({
                type: "replace",
                element: b
            });
        };
        this.isempty = function(a) {
            if (void 0 == this.records[a]) return true;
            return false;
        };
        this.initialize = function(a) {
            if (a < 1) a = 1;
            this.records[a - 1] = -1;
        };
        this.length = function() {
            return this.records.length;
        };
        this.indexOf = function(a) {
            return this.records.indexOf(a);
        };
        this.add = function(a) {
            if (null == a) return false;
            this.records[this.records.length] = a;
            if (!this.updating) this._raiseEvent({
                type: "add",
                element: a
            });
            return true;
        };
        this.insertAt = function(a, b) {
            if (null == a || void 0 == a) return false;
            if (null == b) return false;
            if (a >= 0) if (a < this.records.length) {
                this.records.splice(a, 0, b);
                if (!this.updating) this._raiseEvent({
                    type: "insert",
                    index: a,
                    element: b
                });
                return true;
            } else return this.add(b);
            return false;
        };
        this.remove = function(a) {
            if (null == a || void 0 == a) return false;
            var b = this.records.indexOf(a);
            if (b != -1) {
                this.records.splice(b, 1);
                if (!this.updating) this._raiseEvent({
                    type: "remove",
                    element: a
                });
                return true;
            }
            return false;
        };
        this.removeAt = function(a) {
            if (null == a || void 0 == a) return false;
            if (a < 0) return false;
            if (a < this.records.length) {
                var b = this.records[a];
                this.records.splice(a, 1);
                if (!this.updating) this._raiseEvent({
                    type: "removeAt",
                    index: a,
                    element: b
                });
                return true;
            }
            return false;
        };
        return this;
    };
    a.jqx.dataview = function() {
        this.self = this;
        this.grid = null;
        this.uniqueId = "id";
        this.records = [];
        this.rows = [];
        this.columns = [];
        this.groups = [];
        this.filters = new Array();
        this.updated = null;
        this.update = null;
        this.suspend = false;
        this.pagesize = 0;
        this.pagenum = 0;
        this.totalrows = 0;
        this.totalrecords = 0;
        this.groupable = true;
        this.loadedrecords = [];
        this.loadedrootgroups = [];
        this.loadedgroups = [];
        this.loadedgroupsByKey = [];
        this.virtualmode = true;
        this._cachegrouppages = new Array();
        this.source = null;
        this.changedrecords = new Array();
        this.rowschangecallback = null;
        this.that = this;
        this.destroy = function() {
            delete this.self;
            delete this.grid;
            delete this.uniqueId;
            delete this.records;
            delete this.rows;
            delete this.columns;
            delete this.groups;
            delete this.filters;
            delete this.updated;
            delete this.update;
            delete this.suspend;
            delete this.pagesize;
            delete this.pagenum;
            delete this.totalrows;
            delete this.totalrecords;
            delete this.groupable;
            delete this.loadedrecords;
            delete this.loadedrootgroups;
            delete this.loadedgroups;
            delete this.loadedgroupsByKey;
            delete this.virtualmode;
            delete this._cachegrouppages;
            delete this.source;
            delete this.changedrecords;
            delete this.rowschangecallback;
            delete this.that;
        }, this.suspendupdate = function() {
            this.suspend = true;
        }, this.isupdating = function() {
            return this.suspend;
        }, this.resumeupdate = function(a) {
            this.suspend = false;
            if (void 0 == a) a = true;
            this.refresh(a);
        }, this.getrecords = function() {
            return this.records;
        }, this.clearrecords = function() {
            this.recordids = new Array();
        };
        this.databind = function(b, c) {
            var d = b._source ? true : false;
            var e = null;
            if (d) {
                e = b;
                b = b._source;
            } else e = new a.jqx.dataAdapter(b, {
                autoBind: false
            });
            var f = function(a) {
                e.recordids = [];
                e.records = new Array();
                e.cachedrecords = new Array();
                e.originaldata = new Array();
                e._options.virtualmode = a.virtualmode;
                e._options.totalrecords = a.totalrecords;
                e._options.originaldata = a.originaldata;
                e._options.recordids = a.recordids;
                e._options.cachedrecords = new Array();
                e._options.pagenum = a.pagenum;
                e._options.pageable = a.pageable;
                if (void 0 != b.type) e._options.type = b.type;
                if (void 0 != b.formatdata) e._options.formatData = b.formatdata;
                if (void 0 != b.contenttype) e._options.contentType = b.contenttype;
                if (void 0 != b.async) e._options.async = b.async;
                if (void 0 != b.updaterow) e._options.updaterow = b.updaterow;
                if (void 0 != b.addrow) e._options.addrow = b.addrow;
                if (void 0 != b.deleterow) e._options.deleterow = b.deleterow;
                if (0 == a.pagesize) a.pagesize = 10;
                e._options.pagesize = a.pagesize;
            };
            var g = function(c) {
                c.totalrecords = e.totalrecords;
                if (!c.virtualmode) {
                    c.originaldata = e.originaldata;
                    c.records = e.records;
                    c.recordids = e.recordids;
                    c.cachedrecords = e.cachedrecords;
                } else {
                    var d = {
                        startindex: c.pagenum * c.pagesize,
                        endindex: c.pagenum * c.pagesize + c.pagesize
                    };
                    if (void 0 != b.recordstartindex) d.startindex = parseInt(b.recordstartindex);
                    if (void 0 != b.recordendindex) d.endindex = parseInt(b.recordendindex); else if (!c.grid.pageable) {
                        d.endindex = d.startindex + 100;
                        if (c.grid.autoheight) d.endindex = d.startindex + c.totalrecords;
                    }
                    if (!b.recordendindex) if (!c.grid.pageable) {
                        d.endindex = d.startindex + 100;
                        if (c.grid.autoheight) d.endindex = d.startindex + c.totalrecords;
                    } else d = {
                        startindex: c.pagenum * c.pagesize,
                        endindex: c.pagenum * c.pagesize + c.pagesize
                    };
                    d.data = e.records;
                    if (c.grid.rendergridrows && c.totalrecords > 0) {
                        var f = 0;
                        b.records = c.grid.rendergridrows(d);
                        if (b.records.length) f = b.records.length;
                        if (b.records && !b.records[d.startindex]) {
                            var g = new Array();
                            var h = d.startindex;
                            a.each(b.records, function() {
                                g[h] = this;
                                h++;
                                f++;
                            });
                            b.records = g;
                        }
                        if (0 == f) if (b.records) a.each(b.records, function() {
                            f++;
                        });
                        if (f > 0 && f < d.endindex - d.startindex && !c.grid.groupable) {
                            var i = b.records[0];
                            for (var j = 0; j < d.endindex - d.startindex - f; j++) {
                                var k = {};
                                for (obj in i) k[obj] = "";
                                if (b.records.push) b.records.push(k);
                            }
                        }
                    }
                    if (!b.records || 0 == c.totalrecords) b.records = new Array();
                    c.originaldata = b.records;
                    c.records = b.records;
                    c.cachedrecords = b.records;
                }
            };
            f(this);
            this.source = b;
            if (void 0 !== c) uniqueId = c;
            var h = this.that;
            switch (b.datatype) {
                case "local":
                case "array":
                default:
                    if (null == b.localdata) b.localdata = [];
                    if (null != b.localdata) {
                        e.unbindBindingUpdate(h.grid.element.id);
                        if (!h.grid.autobind && h.grid.isInitialized || h.grid.autobind) e.dataBind();
                        var i = function(c) {
                            if (void 0 != c && "" != c) {
                                var d = e._changedrecords[0];
                                if (d) {
                                    var f = new Array();
                                    a.each(e._changedrecords, function(a) {
                                        var b = this.index;
                                        var d = this.record;
                                        h.grid._updateFromAdapter = true;
                                        switch (c) {
                                            case "update":
                                                var g = h.grid.getrowid(b);
                                                if (a == e._changedrecords.length - 1) h.grid.updaterow(g, d); else h.grid.updaterow(g, d, false);
                                                h.grid._updateFromAdapter = false;
                                                return;

                                            case "add":
                                                h.grid.addrow(null, d);
                                                h.grid._updateFromAdapter = false;
                                                return;

                                            case "remove":
                                                var g = h.grid.getrowid(b);
                                                f.push(g);
                                                return;
                                        }
                                    });
                                    if (f.length > 0) {
                                        h.grid.deleterow(f, false);
                                        h.grid._updateFromAdapter = false;
                                    }
                                }
                                if ("update" == c) return;
                            }
                            var i = h.totalrecords;
                            g(h, c);
                            if (null === b.localdata.notifier && "observableArray" == b.localdata.name) b.localdata.notifier = function(c) {
                                if (this._updating) return;
                                this._updating = true;
                                var d = h.grid.getrowid(c.index);
                                switch (c.type) {
                                    case "add":
                                        var f = a.extend({}, c.object[c.index]);
                                        var g = e.getid(b.id, f, c.index);
                                        h.grid.addrow(g, f);
                                        break;

                                    case "delete":
                                        h.grid.deleterow(d);
                                        break;

                                    case "update":
                                        if (c.path && c.path.split(".").length > 1) {
                                            var i = c.path.split(".");
                                            h.grid.setcellvalue(c.index, i[i.length - 1], c.newValue);
                                        } else {
                                            var f = a.extend({}, c.object[c.index]);
                                            h.grid.updaterow(d, f);
                                        }
                                }
                                this._updating = false;
                            };
                            if ("updateData" == c) {
                                h.refresh();
                                h.grid._updateGridData();
                            } else {
                                if (b.recordstartindex && this.virtualmode) h.updateview(b.recordstartindex, b.recordstartindex + h.pagesize); else h.refresh();
                                h.update(i != h.totalrecords);
                            }
                        };
                        i();
                        e.bindBindingUpdate(h.grid.element.id, i);
                    }
                    break;

                case "json":
                case "jsonp":
                case "xml":
                case "xhtml":
                case "script":
                case "text":
                case "csv":
                case "tab":
                    if (null != b.localdata) {
                        e.unbindBindingUpdate(h.grid.element.id);
                        if (!h.grid.autobind && h.grid.isInitialized || h.grid.autobind) e.dataBind();
                        var i = function(a) {
                            var c = h.totalrecords;
                            g(h);
                            if ("updateData" == a) {
                                h.refresh();
                                h.grid._updateGridData();
                            } else {
                                if (b.recordstartindex && h.virtualmode) h.updateview(b.recordstartindex, b.recordstartindex + h.pagesize); else h.refresh();
                                h.update(c != h.totalrecords);
                            }
                        };
                        i();
                        e.bindBindingUpdate(h.grid.element.id, i);
                        return;
                    }
                    var j = {};
                    var k = 0;
                    var l = {};
                    for (var m = 0; m < this.filters.length; m++) {
                        var n = this.filters[m].datafield;
                        var o = this.filters[m].filter;
                        var p = o.getfilters();
                        l[n + "operator"] = o.operator;
                        for (var q = 0; q < p.length; q++) {
                            p[q].datafield = n;
                            var r = p[q].value;
                            if ("datefilter" == p[q].type) if (p[q].value && p[q].value.toLocaleString) {
                                var s = this.grid.getcolumn(p[q].datafield);
                                if (s.cellsformat) {
                                    var t = this.grid.source.formatDate(p[q].value, s.cellsformat, this.grid.gridlocalization);
                                    if (t) l["filtervalue" + k] = t; else l["filtervalue" + k] = p[q].value.toLocaleString();
                                } else l["filtervalue" + k] = r.toString();
                            } else l["filtervalue" + k] = r.toString(); else {
                                l["filtervalue" + k] = r.toString();
                                if (p[q].data) l["filterid" + k] = p[q].data.toString();
                                if (p[q].id) l["filterid" + k] = p[q].id.toString();
                            }
                            l["filtercondition" + k] = p[q].condition;
                            l["filteroperator" + k] = p[q].operator;
                            l["filterdatafield" + k] = n;
                            k++;
                        }
                    }
                    l.filterscount = k;
                    l.groupscount = h.groups.length;
                    for (var m = 0; m < h.groups.length; m++) l["group" + m] = h.groups[m];
                    if (void 0 == b.recordstartindex) b.recordstartindex = 0;
                    if (void 0 == b.recordendindex || 0 == b.recordendindex) {
                        if (h.grid.height && h.grid.height.toString().indexOf("%") == -1) {
                            b.recordendindex = parseInt(h.grid.height) / h.grid.rowsheight;
                            b.recordendindex += 2;
                            b.recordendindex = parseInt(b.recordendindex);
                        } else {
                            b.recordendindex = a(window).height() / h.grid.rowsheight;
                            b.recordendindex = parseInt(b.recordendindex);
                        }
                        if (this.pageable) b.recordendindex = this.pagesize;
                    }
                    if (this.pageable) {
                        b.recordstartindex = this.pagenum * this.pagesize;
                        b.recordendindex = (this.pagenum + 1) * this.pagesize;
                    }
                    a.extend(l, {
                        sortdatafield: h.sortfield,
                        sortorder: h.sortfielddirection,
                        pagenum: h.pagenum,
                        pagesize: h.grid.pagesize,
                        recordstartindex: b.recordstartindex,
                        recordendindex: b.recordendindex
                    });
                    var u = e._options.data;
                    if (e._options.data) a.extend(e._options.data, l); else {
                        if (b.data) a.extend(l, b.data);
                        e._options.data = l;
                    }
                    var i = function() {
                        var c = a.jqx.browser.msie && a.jqx.browser.version < 9;
                        var d = function() {
                            var a = h.totalrecords;
                            g(h);
                            if (b.recordstartindex && h.virtualmode) h.updateview(b.recordstartindex, b.recordstartindex + h.pagesize); else h.refresh();
                            h.update(a != h.totalrecords);
                        };
                        if (c) try {
                            d();
                        } catch (e) {} else d();
                    };
                    e.unbindDownloadComplete(h.grid.element.id);
                    e.bindDownloadComplete(h.grid.element.id, i);
                    if (!h.grid.autobind && h.grid.isInitialized || h.grid.autobind) e.dataBind(); else if (!h.grid.isInitialized && !h.grid.autobind) i();
                    e._options.data = u;
            }
        };
        this.getid = function(b, c, d) {
            if (a(b, c).length > 0) return a(b, c).text();
            if (b) if (b.toString().length > 0) {
                var e = a(c).attr(b);
                if (null != e && e.toString().length > 0) return e;
            }
            return d;
        };
        this.getvaluebytype = function(b, c) {
            var d = b;
            if ("date" == c.type) {
                var e = new Date(b);
                if ("NaN" == e.toString() || "Invalid Date" == e.toString()) if (a.jqx.dataFormat) b = a.jqx.dataFormat.tryparsedate(b); else b = e; else b = e;
                if (null == b) b = d;
            } else if ("float" == c.type) {
                var b = parseFloat(b);
                if (isNaN(b)) b = d;
            } else if ("int" == c.type) {
                var b = parseInt(b);
                if (isNaN(b)) b = d;
            } else if ("bool" == c.type) {
                if (null != b) if ("false" == b.toLowerCase()) b = false; else if ("true" == b.toLowerCase()) b = true;
                if (1 == b) b = true; else if (0 == b) b = false; else b = "";
            }
            return b;
        };
        this.setpaging = function(a) {
            if (void 0 != a.pageSize) this.pagesize = a.pageSize;
            if (void 0 != a.pageNum) this.pagenum = Math.min(a.pageNum, Math.ceil(this.totalrows / this.pagesize));
            this.refresh();
        };
        this.getpagingdetails = function() {
            return {
                pageSize: this.pagesize,
                pageNum: this.pagenum,
                totalrows: this.totalrows
            };
        };
        this._clearcaches = function() {
            this.sortcache = {};
            this.sortdata = null;
            this.changedrecords = new Array();
            this.records = new Array();
            this.rows = new Array();
            this.cacheddata = new Array();
            this.originaldata = new Array();
            this.bounditems = new Array();
            this.loadedrecords = new Array();
            this.loadedrootgroups = new Array();
            this.loadedgroups = new Array();
            this.loadedgroupsByKey = new Array();
            this._cachegrouppages = new Array();
            this.recordsbyid = new Array();
            this.cachedrecords = new Array();
            this.recordids = new Array();
        };
        this.addfilter = function(a, b) {
            var c = -1;
            for (var d = 0; d < this.filters.length; d++) if (this.filters[d].datafield == a) {
                c = d;
                break;
            }
            if (c == -1) this.filters[this.filters.length] = {
                filter: b,
                datafield: a
            }; else this.filters[c] = {
                filter: b,
                datafield: a
            };
        };
        this.removefilter = function(a) {
            for (var b = 0; b < this.filters.length; b++) if (this.filters[b].datafield == a) {
                this.filters.splice(b, 1);
                break;
            }
        };
        this.getItemFromIndex = function(a) {
            return this.records[a];
        };
        this.updaterow = function(a, b, c) {
            var d = this.filters && this.filters.length > 0 && !this.virtualmode;
            if (!d && void 0 != b && void 0 != a) {
                b.uid = a;
                if (!b[this.source.id]) b[this.source.id] = b.uid;
                var e = this.recordsbyid["id" + a];
                var f = this.records.indexOf(e);
                if (f == -1) return false;
                this.records[f] = b;
                if (this.cachedrecords) this.cachedrecords[f] = b;
                if (true == c || void 0 == c) this.refresh();
                this.changedrecords[b.uid] = {
                    Type: "Update",
                    OldData: e,
                    Data: b
                };
                return true;
            } else if (this.filters && this.filters.length > 0) {
                var g = this.cachedrecords;
                var e = null;
                var f = -1;
                for (var h = 0; h < g.length; h++) if (g[h].uid == a) {
                    e = g[h];
                    f = h;
                    break;
                }
                if (e) {
                    var i = this.that;
                    for (var j in b) i.cachedrecords[f][j] = b[j];
                    if (true == c || void 0 == c) this.refresh();
                    return true;
                }
            }
            return false;
        };
        this.addrow = function(a, b, c, d) {
            if (void 0 != b) {
                if (!a || this.recordsbyid["id" + a]) {
                    b.uid = this.getid(this.source.id, b, this.totalrecords);
                    var e = this.recordsbyid["id" + b.uid];
                    while (null != e) {
                        var f = Math.floor(1e4 * Math.random()).toString();
                        b.uid = f;
                        e = this.recordsbyid["id" + f];
                    }
                } else b.uid = a;
                if (!b[this.source.id]) if (void 0 != this.source.id) b[this.source.id] = b.uid;
                if ("last" == c) this.records.push(b); else if ("number" === typeof c && isFinite(c)) this.records.splice(c, 0, b); else this.records.splice(0, 0, b);
                if (this.filters && this.filters.length > 0) if ("last" == c) this.cachedrecords.push(b); else if ("number" === typeof c && isFinite(c)) this.cachedrecords.splice(c, 0, b); else this.cachedrecords.splice(0, 0, b);
                this.totalrecords++;
                if (this.virtualmode) this.source.totalrecords = this.totalrecords;
                if (true == d || void 0 == d) this.refresh();
                this.changedrecords[b.uid] = {
                    Type: "New",
                    Data: b
                };
                return true;
            }
            return false;
        };
        this.deleterow = function(a, b) {
            if (void 0 != a) {
                var c = this.filters && this.filters.length > 0;
                if (this.recordsbyid["id" + a] && !c) {
                    var d = this.recordsbyid["id" + a];
                    var e = this.records.indexOf(d);
                    this.changedrecords[a] = {
                        Type: "Delete",
                        Data: this.records[e]
                    };
                    this.records.splice(e, 1);
                    this.totalrecords--;
                    if (this.virtualmode) this.source.totalrecords = this.totalrecords;
                    if (true == b || void 0 == b) this.refresh();
                    return true;
                } else if (this.filters && this.filters.length > 0) {
                    var f = this.cachedrecords;
                    var d = null;
                    var e = -1;
                    for (var g = 0; g < f.length; g++) if (f[g].uid == a) {
                        d = f[g];
                        e = g;
                        break;
                    }
                    if (d) {
                        this.cachedrecords.splice(e, 1);
                        if (true == b || void 0 == b) {
                            this.totalrecords = 0;
                            this.records = this.cachedrecords;
                            this.refresh();
                        }
                        return true;
                    }
                }
                return false;
            }
            return false;
        };
        this.reload = function(b, c, d, e, f, g, h) {
            var i = this.that;
            var j = new Array();
            var k = b;
            var l = c;
            var m = d;
            var n = e;
            var o = l.length;
            var p = 0;
            var q = 0;
            var r, s;
            this.columns = [];
            this.bounditems = new Array();
            this.loadedrecords = new Array();
            this.loadedrootgroups = new Array();
            this.loadedgroups = new Array();
            this.loadedgroupsByKey = new Array();
            this._cachegrouppages = new Array();
            this.recordsbyid = {};
            if (0 == this.totalrecords) {
                Object.size = function(a) {
                    var b = 0, c;
                    for (c in a) if (a.hasOwnProperty(c)) b++;
                    return b;
                };
                var t = Object.size(k);
                this.totalrecords = t;
                a.each(this.records, function(b) {
                    var c = this;
                    var d = 0;
                    a.each(c, function(a, b) {
                        i.columns[d++] = a;
                    });
                    return false;
                });
            }
            if (this.virtualmode) {
                if (this.pageable) {
                    this.updateview();
                    return;
                }
                var g = 0;
                if (!this.groupable) {
                    this.updateview();
                    return;
                } else var h = this.totalrecords;
            } else {
                var g = 0;
                var h = this.totalrecords;
            }
            if (this.groupable && this.groups.length > 0 && this.loadgrouprecords) {
                var u = g;
                u = this.loadgrouprecords(0, g, h, m, q, n, l, o, j);
            } else p = this.loadflatrecords(g, h, m, q, n, l, o, j);
            if (o > q) l.splice(q, o - q);
            if (this.groups.length > 0 && this.groupable) this.totalrows = u; else this.totalrows = p;
            return j;
        };
        this.loadflatrecords = function(b, c, d, e, f, g, h, i) {
            var j = this.that;
            var k = b;
            var l = b;
            c = Math.min(c, this.totalrecords);
            var m = null != this.sortdata;
            var n = this.source.id && ("local" == this.source.datatype || "array" == this.source.datatype || "" == this.source.datatype);
            var o = m ? this.sortdata : this.records;
            for (var p = b; p < c; p++) {
                var q = {};
                if (!m) {
                    q = a.extend({}, o[p]);
                    id = q[j.uniqueId];
                    q.boundindex = k;
                    j.loadedrecords[k] = q;
                    if (void 0 == q.uid) q.uid = j.getid(j.source.id, q, k);
                    j.recordsbyid["id" + q.uid] = o[p];
                    q.uniqueid = j.generatekey();
                    j.bounditems[this.bounditems.length] = q;
                } else {
                    q = a.extend({}, o[p].value);
                    id = q[j.uniqueId];
                    q.boundindex = o[p].index;
                    if (void 0 == q.uid) q.uid = j.getid(j.source.id, q, q.boundindex);
                    j.recordsbyid["id" + q.uid] = o[p].value;
                    j.loadedrecords[k] = q;
                    q.uniqueid = j.generatekey();
                    j.bounditems[q.boundindex] = q;
                }
                if (e >= h || id != g[e][j.uniqueId] || f && f[id]) i[i.length] = e;
                g[e] = q;
                e++;
                q.visibleindex = l;
                l++;
                k++;
            }
            if (j.grid.summaryrows) {
                var r = k;
                a.each(j.grid.summaryrows, function() {
                    var b = a.extend({}, this);
                    b.boundindex = c++;
                    j.loadedrecords[r] = b;
                    b.uniqueid = j.generatekey();
                    j.bounditems[j.bounditems.length] = b;
                    g[e] = b;
                    e++;
                    b.visibleindex = l;
                    l++;
                    r++;
                });
            }
            return l;
        }, this.updateview = function(a, b) {
            var c = this.that;
            var d = this.pagesize * this.pagenum;
            var e = 0;
            var f = new Array();
            var g = this.filters;
            var h = this.updated;
            var i = f.length;
            if (this.pageable) {
                if (this.virtualmode) if (!this.groupable || 0 == this.groups.length) {
                    this.loadflatrecords(this.pagesize * this.pagenum, this.pagesize * (1 + this.pagenum), g, e, h, f, i, []);
                    this.totalrows = f.length;
                } else if (this.groupable && this.groups.length > 0 && this.loadgrouprecords) {
                    if (void 0 != this._cachegrouppages[this.pagenum + "_" + this.pagesize]) {
                        this.rows = this._cachegrouppages[this.pagenum + "_" + this.pagesize];
                        this.totalrows = this.rows.length;
                        return;
                    }
                    var j = this.pagesize * (1 + this.pagenum);
                    if (j > this.totalrecords) j = this.totalrecords;
                    this.loadgrouprecords(0, this.pagesize * this.pagenum, j, g, e, h, f, i, []);
                    this._cachegrouppages[this.pagenum + "_" + this.pagesize] = this.rows;
                    this.totalrows = this.rows.length;
                    return;
                }
            } else if (this.virtualmode && (!this.groupable || 0 == this.groups.length)) {
                var k = this.pagesize;
                if (0 == k) k = Math.min(100, this.totalrecords);
                var l = k * this.pagenum;
                if (0 == this.loadedrecords.length) l = 0;
                if (null != a && null != b) this.loadflatrecords(a, b, g, e, h, f, i, []); else this.loadflatrecords(this.pagesize * this.pagenum, this.pagesize * (1 + this.pagenum), g, e, h, f, i, []);
                this.totalrows = this.loadedrecords.length;
                this.rows = f;
                if (f.length >= k) return;
            }
            if (this.groupable && this.pageable && this.groups.length > 0 && this._updategroupsinpage) f = this._updategroupsinpage(c, g, d, e, i, this.pagesize * this.pagenum, this.pagesize * (1 + this.pagenum)); else for (var m = this.pagesize * this.pagenum; m < this.pagesize * (1 + this.pagenum); m++) {
                var n = m < this.loadedrecords.length ? this.loadedrecords[m] : null;
                if (null == n) continue;
                if (!this.pagesize || d >= this.pagesize * this.pagenum && d <= this.pagesize * (this.pagenum + 1)) {
                    f[e] = n;
                    e++;
                }
                d++;
            }
            if ((0 == f.length || f.length < this.pagesize) && !this.pageable && this.virtualmode) {
                e = f.length;
                var o = f.length;
                for (var m = this.pagesize * this.pagenum; m < this.pagesize * (1 + this.pagenum) - o; m++) {
                    var n = {};
                    n.boundindex = m + o;
                    n.visibleindex = m + o;
                    n.uniqueid = c.generatekey();
                    n.empty = true;
                    c.bounditems[m + o] = n;
                    f[e] = n;
                    e++;
                }
            }
            this.rows = f;
        };
        this.generatekey = function() {
            var a = function() {
                return 16 * (1 + Math.random()) | 0;
            };
            return "" + a() + a() + "-" + a() + "-" + a() + "-" + a() + "-" + a() + a() + a();
        };
        this.reloaddata = function() {
            this.reload(this.records, this.rows, this.filter, this.updated, true);
        };
        this.refresh = function(b) {
            if (this.suspend) return;
            if (void 0 == b) b = true;
            var c = this.rows.length;
            var d = this.totalrows;
            if (this.filters.length > 0 && !this.virtualmode) {
                var e = "";
                var f = this.cachedrecords.length;
                var g = new Array();
                this.totalrecords = 0;
                var h = this.cachedrecords;
                this._dataIndexToBoundIndex = new Array();
                var i = this.filters.length;
                if (null != this.source && void 0 != this.source.filter && void 0 != this.source.localdata) {
                    g = this.source.filter(this.filters, h, f);
                    if (void 0 == g) g = new Array();
                    this.records = g;
                } else if (null == this.source.filter || void 0 == this.source.filter) {
                    for (var j = 0; j < f; j++) {
                        var k = h[j];
                        var l = void 0;
                        for (var m = 0; m < i; m++) {
                            var e = this.filters[m].filter;
                            var n = k[this.filters[m].datafield];
                            var o = e.evaluate(n);
                            if (void 0 == l) l = o; else if ("or" == e.operator) l = l || o; else l = l && o;
                        }
                        if (l) {
                            g[g.length] = a.extend({
                                dataindex: j
                            }, k);
                            this._dataIndexToBoundIndex[j] = {
                                boundindex: g.length - 1
                            };
                        } else this._dataIndexToBoundIndex[j] = null;
                    }
                    this.records = g;
                }
                if (this.sortdata) {
                    var p = this.sortfield;
                    if (this.sortcache[p]) {
                        this.sortdata = null;
                        var q = this.sortcache[p].direction;
                        this.sortcache[p] = null;
                        this.sortby(this.sortfield, q);
                        return;
                    }
                }
            } else if (0 == this.filters.length && !this.virtualmode) if (this.cachedrecords) {
                this.totalrecords = 0;
                var h = this.cachedrecords;
                this.records = h;
                if (this.sortdata) {
                    var p = this.sortfield;
                    if (this.sortcache[p]) {
                        this.sortdata = null;
                        var q = this.sortcache[p].direction;
                        this.sortcache[p] = null;
                        this.sortby(this.sortfield, q);
                        return;
                    }
                }
            }
            var r = this.reload(this.records, this.rows, this.filter, this.updated, b);
            this.updated = null;
            if (null != this.rowschangecallback) {
                if (d != totalrows) this.rowschangecallback({
                    type: "PagingChanged",
                    data: getpagingdetails()
                });
                if (c != rows.length) this.rowschangecallback({
                    type: "RowsCountChanged",
                    data: {
                        previous: c,
                        current: rows.length
                    }
                });
                if (r.length > 0 || c != rows.length) this.rowschangecallback({
                    type: "RowsChanged",
                    data: {
                        previous: c,
                        current: rows.length,
                        diff: r
                    }
                });
            }
        };
        return this;
    };
}(jqxBaseFramework);