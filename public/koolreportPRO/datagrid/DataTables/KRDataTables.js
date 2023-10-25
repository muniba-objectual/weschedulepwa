var KoolReport = KoolReport || {};
KoolReport.KRDataTables = KoolReport.KRDataTables || (function (global) {

    function findMatchedAncestor(el, selector) {
        while (el && !el.matches(selector)) el = el.parentElement;
        return el;
    }

    var dt = {};

    dt.expandCollapse = function (expandCollapseSpan) {
        // console.log(expandCollapseSpan);
        var dtState = global[this.id + '_state'];
        var isExpand = expandCollapseSpan.classList.contains('group-expand');
        var tr = findMatchedAncestor(expandCollapseSpan, 'tr');
        var isGroupStart = tr.classList.contains('dtrg-start');
        var level = 1 * tr.className.match(/dtrg-level-(\d+)/)[1];
        var tmpTr = tr;
        while (tmpTr) {
            tmpTr = isGroupStart ? tmpTr.nextElementSibling : tmpTr.previousElementSibling;
            if (!tmpTr) break;
            if (tmpTr.classList.contains('dtrg-group')) {
                var tmpLevel = 1 * tmpTr.className.match(/dtrg-level-(\d+)/)[1];
            } else {
                var tmpLevel = 9999;
            }
            if (tmpLevel > level) {
                var emptyGroupRow = tmpTr.classList.contains('dtrg-group') && tmpTr.children.length === 0;
                if (!emptyGroupRow) {
                    var tmpGroupSignature = tmpTr.dataset.dtrgSignature;
                    var tmpDtrgState = tmpGroupSignature ? (dtState.dtrg[tmpGroupSignature] || {}) : {};
                    var layer = tmpTr.dataset.layer || tmpDtrgState.layer || 1;
                    layer = 1 * layer;
                    if (isExpand) {
                        tmpTr.dataset.layer = layer + 1;
                    } else {
                        tmpTr.dataset.layer = layer - 1;
                    }
                    tmpTr.style.display = 1 * tmpTr.dataset.layer > 0 ? '' : 'none';
                    var tmpGroupSignature = tmpTr.dataset.dtrgSignature;
                    if (tmpGroupSignature && tmpDtrgState) {
                        tmpDtrgState.layer = tmpTr.dataset.layer;
                    }
                }
            } else if (tmpLevel === level) {
                var matchedExpandSpan = tmpTr.querySelector('.group-expand');
                var matchedCollapseSpan = tmpTr.querySelector('.group-collapse');
                if (matchedExpandSpan && matchedCollapseSpan) {
                    matchedExpandSpan.style.display = isExpand ? 'none' : '';
                    matchedCollapseSpan.style.display = isExpand ? '' : 'none';
                }
                break;
            }
        }
        expandCollapseSpan.style.display = 'none';
        var collpseExpandSpan = isExpand ?
            expandCollapseSpan.nextElementSibling : expandCollapseSpan.previousElementSibling;
        collpseExpandSpan.style.display = '';

        var groupSignature = tr.dataset.dtrgSignature;
        dtState.dtrg[groupSignature].collapse = !isExpand;
    }

    dt.expandAllGroups = function (level) {
        var groupsToggled = [];
        var allTrGroups = document.querySelectorAll("#" + this.id + " tr.dtrg-level-" + level);
        allTrGroups.forEach(trGroup => {
            var groupSignature = trGroup.dataset.dtrgSignature;
            if (groupsToggled.indexOf(groupSignature) !== -1) return;

            groupsToggled.push(groupSignature);
            var expandIcon = trGroup.querySelector("span.group-expand");
            if (expandIcon && expandIcon.style.display !== 'none') expandIcon.click();
        });
    };

    dt.collapseAllGroups = function (level) {
        var groupsToggled = [];
        var allTrGroups = document.querySelectorAll("#" + this.id + " tr.dtrg-level-" + level);
        allTrGroups.forEach(trGroup => {
            var groupSignature = trGroup.dataset.dtrgSignature;
            if (groupsToggled.indexOf(groupSignature) !== -1) return;

            groupsToggled.push(groupSignature);
            var collapseIcon = trGroup.querySelector("span.group-collapse");
            if (collapseIcon && collapseIcon.style.display !== 'none') collapseIcon.click();
        });
    };

    dt.toggleAllGroups = function (level) {
        var groupsToggled = [];
        var allTrGroups = document.querySelectorAll("#" + this.id + " tr.dtrg-level-" + level);
        allTrGroups.forEach(trGroup => {
            var groupSignature = trGroup.dataset.dtrgSignature;
            if (groupsToggled.indexOf(groupSignature) !== -1) return;

            groupsToggled.push(groupSignature);
            var expandIcon = trGroup.querySelector("span.group-expand");
            var collapseIcon = trGroup.querySelector("span.group-collapse");
            if (expandIcon && expandIcon.style.display !== 'none') {
                expandIcon.click();
            } else if (collapseIcon && collapseIcon.style.display !== 'none') {
                collapseIcon.click();
            }
        });
    };

    dt.expandRowDetail = function (i) {
        var rowEl = document.querySelectorAll("#" + this.id + " tbody tr[role='row']")[i];
        var expandDetailIcon = rowEl.querySelector('.details-control .fa-plus-square');
        if (expandDetailIcon) expandDetailIcon.click();
    };

    dt.collapseRowDetail = function (i) {
        var rowEl = document.querySelectorAll("#" + this.id + " tbody tr[role='row']")[i];
        var collapseDetailIcon = rowEl.querySelector('.details-control .fa-minus-square');
        if (collapseDetailIcon) collapseDetailIcon.click();
    };

    dt.toggleRowDetail = function (i) {
        var rowEl = document.querySelectorAll("#" + this.id + " tbody tr[role='row']")[i];
        var expandCollapseDetailIcon = rowEl.querySelector('.details-control .expand-collapse-detail-icon');
        if (expandCollapseDetailIcon) expandCollapseDetailIcon.click();
    };

    dt.expandAllRowDetails = function () {
        var rowEls = document.querySelectorAll("#" + this.id + " tbody tr[role='row']");
        rowEls.forEach(function (rowEl) {
            var expandDetailIcon = rowEl.querySelector('.details-control .fa-plus-square');
            if (expandDetailIcon) expandDetailIcon.click();
        });
    };

    dt.collapseAllRowDetails = function () {
        var rowEls = document.querySelectorAll("#" + this.id + " tbody tr[role='row']");
        rowEls.forEach(function (rowEl) {
            var collapseDetailIcon = rowEl.querySelector('.details-control .fa-minus-square');
            if (collapseDetailIcon) collapseDetailIcon.click();
        });
    };

    dt.toggleAllRowDetails = function () {
        var rowEls = document.querySelectorAll("#" + this.id + " tbody tr[role='row']");
        rowEls.forEach(function (rowEl) {
            var expandCollapseDetailIcon = rowEl.querySelector('.details-control .expand-collapse-detail-icon');
            if (expandCollapseDetailIcon) expandCollapseDetailIcon.click();
        });
    };

    dt.addRow = function () {
        var dtObj = global[this.id];
        var newDefaultRawData = {};
        var newDefaultInputs = [];
        var newDefaultData = [];
        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
            var colName = this.showColumnKeys[i];
            var colSetting = this.columns[colName];
            var role = (colSetting.role || "").split("|");
            if (role.indexOf("edit") > -1 || role.indexOf("delete") > -1) {
                var inputs = "";
                if (role.indexOf("edit") > -1) {
                    inputs += this.editButtons["cancelInsert"] + this.editButtons["insert"];
                }
                newDefaultInputs.push(inputs);
                newDefaultData.push("");
            } else if (!colSetting.insertable) {
                newDefaultInputs.push("");
                newDefaultData.push("");
            } else {
                var type = colSetting.inputType || colSetting.type || "string";
                var typeToInputType = {
                    "string": "text",
                    "datetime": "datetime-local"
                };
                var inputType = typeToInputType[type] || type;
                var innerHTML = `<input type='${inputType}' value='' />`;
                newDefaultInputs.push(innerHTML);
                newDefaultData.push("");
                newDefaultRawData[colName] = "";
            }
        }
        var dtRow = dtObj.row.add(newDefaultInputs);

        var tr = dtRow.node();
        this.addEditButtonsListener(tr);

        dtObj.draw(true);
        this.rawData.push(JSON.parse(JSON.stringify(newDefaultRawData)));
    };

    dt.cancelInsertRow = function (el) {
        var dtObj = global[this.id];
        var tr = findMatchedAncestor(el, 'tr');
        var dtRow = dtObj.row(tr);
        var rowIndex = dtRow.index();
        this.rawData.splice(rowIndex, 1);
        dtRow.remove();
        dtObj.draw();
    };

    dt.insertRow = function (el) {
        var dtObj = global[this.id];
        var tr = findMatchedAncestor(el, 'tr');
        var dtRow = dtObj.row(tr);
        var rowIndex = dtRow.index();
        var rowData = this.rawData[rowIndex];
        var ajaxData = {};
        ajaxData[this.id] = {
            insertParams: {}
        };
        var tds = tr.querySelectorAll("td");
        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
            var colName = this.showColumnKeys[i];
            var colSetting = this.columns[colName];
            if (colSetting.insertable) {
                var td = tds[i];
                var editedValue = td.querySelector("input").value;
                ajaxData[this.id]['insertParams'][":" + colName] = editedValue;
            }
        }
        var ajax = {
            method: "post",
            data: ajaxData,
            success: function (result) {
                // console.log(result);
                var markStart = `<dt-ajax-edit id='${this.id}'>`;
                var markEnd = '</dt-ajax-edit>';
                var start = result.indexOf(markStart);
                var end = result.indexOf(markEnd);
                var resultJson = result.substring(start + markStart.length, end);
                // console.log(resultJson);
                try {
                    resultJson = JSON.parse(resultJson);
                    // console.log(resultJson);
                    if (resultJson.success) {
                        var formattedRow = resultJson.formattedRow || {};
                        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
                            var colName = this.showColumnKeys[i];
                            var colSetting = this.columns[colName];
                            if (colSetting.insertable) {
                                var editedValue = ajaxData[this.id]['insertParams'][":" + colName];
                                this.rawData[rowIndex][colName] = editedValue;
                                var td = tds[i];
                                td.innerHTML = typeof formattedRow[colName] != "undefined" ?
                                    formattedRow[colName] : editedValue;
                            }
                        }
                        var currentTd = findMatchedAncestor(el, 'td');
                        currentTd.innerHTML = "";
                        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
                            var colName = this.showColumnKeys[i];
                            var colSetting = this.columns[colName];
                            var role = (colSetting.role || "").split("|");
                            var editActions = Object.keys(this.editButtons);
                            var innerHTML = "";
                            editActions.forEach(function (editAction) {
                                if (role.indexOf(editAction) > -1) {
                                    innerHTML += this.editButtons[editAction];
                                }
                                if (role.indexOf("edit") > -1) {
                                    innerHTML += this.editButtons["cancelEdit"] + this.editButtons["update"];
                                }
                            }.bind(this));
                            var td = tds[i];
                            if (innerHTML) td.innerHTML += innerHTML;
                            this.addEditButtonsListener(td);
                        }


                    } else {
                        console.log('Insert error: ' + (resultJson.message || ""));
                        alert('Insert error: ' + (resultJson.message || ""));
                    }
                } catch (e) {
                    console.log('Insert error: ' + e.message);
                    alert('Insert error: ' + e.message);
                }

            }.bind(this),
            error: function (error) {

            }
        };
        if (this.editUrl) ajax.url = this.editUrl;
        $.ajax(ajax);
    };

    dt.deleteRow = function (el) {
        var result = window.confirm("Are you sure deleting this row?");
        if (!result) return;
        var dtObj = global[this.id];
        var tr = findMatchedAncestor(el, 'tr');
        var dtRow = dtObj.row(tr);
        var rowIndex = dtRow.index();
        var rowData = this.rawData[rowIndex];
        var ajaxData = {};
        ajaxData[this.id] = {
            deleteParams: {}
        };
        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
            var colName = this.showColumnKeys[i];
            var colSetting = this.columns[colName];
            if (colSetting.role == "id") ajaxData[this.id]['deleteParams'][":" + colName] = rowData[colName];
        }
        var ajax = {
            method: "post",
            data: ajaxData,
            success: function (result) {
                // console.log(result);
                var markStart = `<dt-ajax-edit id='${this.id}'>`;
                var markEnd = '</dt-ajax-edit>';
                var start = result.indexOf(markStart);
                var end = result.indexOf(markEnd);
                var resultJson = result.substring(start + markStart.length, end);
                // console.log(resultJson);
                try {
                    resultJson = JSON.parse(resultJson);
                    // console.log(resultJson);
                    if (resultJson.success) {
                        this.rawData.splice(rowIndex, 1);
                        this.dataRows.splice(rowIndex, 1);
                        dtRow.remove();
                        dtObj.draw();
                    } else {
                        console.log('Update error: ' + (resultJson.message || ""));
                        alert('Update error: ' + (resultJson.message || ""));
                    }
                } catch (e) {
                    console.log('Delete error: ' + e.message);
                    alert('Delete error: ' + e.message);
                }
            }.bind(this),
            error: function (error) {

            }
        };
        if (this.editUrl) ajax.url = this.editUrl;
        $.ajax(ajax);
    };

    dt.editRow = function (el) {
        var dtObj = global[this.id];
        var tr = findMatchedAncestor(el, 'tr');
        var dtRow = dtObj.row(tr);
        var rowIndex = dtRow.index();
        var rowData = this.rawData[rowIndex];
        var tds = tr.querySelectorAll("td");
        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
            var colName = this.showColumnKeys[i];
            var colSetting = this.columns[colName];
            if (!colSetting.editable) continue;
            var type = colSetting.inputType || colSetting.type || "string";
            var typeToInputType = {
                "string": "text",
                "datetime": "datetime-local",
            };
            var inputType = typeToInputType[type] || type;
            var td = tds[i];
            td.dataset.formattedValue = td.innerHTML;
            var currentValue = rowData[colName];
            td.innerHTML = `<input type='${inputType}' />`;
            td.querySelector('input').value = currentValue;
        }
        var td = findMatchedAncestor(el, 'td');
        var editBtnWrapper = td.querySelector(".btn-edit-wrapper");
        var cancelEditBtnWrapper = td.querySelector(".btn-cancelEdit-wrapper");
        var updateBtnWrapper = td.querySelector(".btn-update-wrapper");
        editBtnWrapper.style.display = "none";
        cancelEditBtnWrapper.style.display = "";
        updateBtnWrapper.style.display = "";
    };

    dt.cancelEditRow = function (el) {
        var dtObj = global[this.id];
        var tr = findMatchedAncestor(el, 'tr');
        var dtRow = dtObj.row(tr);
        var rowIndex = dtRow.index();
        // var formattedRowData = this.dataRows[rowIndex] || this.rawData[rowIndex];
        var tds = tr.querySelectorAll("td");
        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
            var colName = this.showColumnKeys[i];
            var colSetting = this.columns[colName];
            if (!colSetting.editable) continue;
            var td = tds[i];
            // var currentFormattedValue = formattedRowData[colName];
            // td.innerHTML = currentFormattedValue;
            td.innerHTML = td.dataset.formattedValue;
        }
        var td = findMatchedAncestor(el, 'td');
        var editBtnWrapper = td.querySelector(".btn-edit-wrapper");
        var cancelEditBtnWrapper = td.querySelector(".btn-cancelEdit-wrapper");
        var updateBtnWrapper = td.querySelector(".btn-update-wrapper");
        editBtnWrapper.style.display = "";
        cancelEditBtnWrapper.style.display = "none";
        updateBtnWrapper.style.display = "none";
    };

    dt.updateRow = function (el) {
        var dtObj = global[this.id];
        var tr = findMatchedAncestor(el, 'tr');
        var dtRow = dtObj.row(tr);
        var rowIndex = dtRow.index();
        var rowData = this.rawData[rowIndex];
        var ajaxData = {};
        ajaxData[this.id] = {
            updateParams: {}
        };
        var tds = tr.querySelectorAll("td");
        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
            var colName = this.showColumnKeys[i];
            var colSetting = this.columns[colName];
            if (colSetting.role == "id") {
                ajaxData[this.id]['updateParams'][":" + colName] = rowData[colName];
            }
            if (colSetting.editable) {
                var td = tds[i];
                var editedValue = td.querySelector("input").value;
                ajaxData[this.id]['updateParams'][":" + colName] = editedValue;
            }
        }
        var ajax = {
            method: "post",
            data: ajaxData,
            success: function (result) {
                // console.log(result);
                var markStart = `<dt-ajax-edit id='${this.id}'>`;
                var markEnd = '</dt-ajax-edit>';
                var start = result.indexOf(markStart);
                var end = result.indexOf(markEnd);
                var resultJson = result.substring(start + markStart.length, end);
                // console.log(resultJson);
                try {
                    resultJson = JSON.parse(resultJson);
                    // console.log(resultJson);
                    if (resultJson.success) {
                        var formattedRow = resultJson.formattedRow || {};
                        for (var i = 0; i < this.showColumnKeys.length; i += 1) {
                            var colName = this.showColumnKeys[i];
                            var colSetting = this.columns[colName];
                            if (colSetting.editable) {
                                var editedValue = ajaxData[this.id]['updateParams'][":" + colName];
                                this.rawData[rowIndex][colName] = editedValue;
                                var td = tds[i];
                                td.innerHTML = typeof formattedRow[colName] != "undefined" ?
                                    formattedRow[colName] : editedValue;
                            }
                        }
                        var td = findMatchedAncestor(el, 'td');
                        var editBtnWrapper = td.querySelector(".btn-edit-wrapper");
                        var cancelEditBtnWrapper = td.querySelector(".btn-cancelEdit-wrapper");
                        var updateBtnWrapper = td.querySelector(".btn-update-wrapper");
                        editBtnWrapper.style.display = "";
                        cancelEditBtnWrapper.style.display = "none";
                        updateBtnWrapper.style.display = "none";
                    } else {
                        console.log('Update error: ' + (resultJson.message || ""));
                        alert('Update error: ' + (resultJson.message || ""));
                    }
                } catch (e) {
                    console.log('Update error: ' + e.message);
                    alert('Update error: ' + e.message);
                }
            }.bind(this),
            error: function (error) {

            }
        };
        if (this.editUrl) ajax.url = this.editUrl;
        $.ajax(ajax);
    };

    dt.addEditButtonsListener = function (el) {
        var editActions = Object.keys(this.editButtons);
        editActions.forEach(function (editAction) {
            var editButtonsWrapper = el.querySelectorAll(`.btn-${editAction}-wrapper`);
            for (var i = 0; i < editButtonsWrapper.length; i += 1) {
                var editButtonWrapper = editButtonsWrapper[i];
                var editButton = editButtonWrapper.children[0];
                if (editButton) {
                    editButton.addEventListener("click", function (e) {
                        this[editAction + "Row"](e.currentTarget);
                    }.bind(this));
                } else {
                    console.log(`There's no ${editAction} button html`);
                }
            }
        }.bind(this));
    }

    dt.bindSearchOnEnter = function () {
        var id = this.id;
        var jQdt = global[id];
        var KRdt = this;

        function strToPhrases(str) {
            var phrases = [];

            // get phrases in double quotes
            str = str.replace(/"([^"]*)"/g, function (match, p1, offset, str) {
                if (p1 !== "") phrases.push(p1);
                return "";
            });

            // get phrases splitted by blank or tab
            str = str.replace(/[^\s\t]*/g, function (match, offset, str) {
                if (match !== "") phrases.push(match);
                return "";
            });

            return phrases;
        }

        function hasSearchMode(mode) {
            return typeof KRdt.searchMode[mode] !== 'undefined';
        }

        function strToRegexStr(str) {
            if (hasSearchMode('or')) {
                str = str.trim();
                str = str.replace(/^\s*or\s+/gi, "");
                str = str.replace(/\s+or\s*$/gi, "");
                str = str.replace(/\sor\s/gi, " or ");
                var orSearches = str.split(' or ');
            } else {
                var orSearches = [str];
            }
            // console.log('orSearches = ', orSearches);
            var orSearchRegexes = [];
            for (var i = 0; i < orSearches.length; i += 1) {
                var orSearchPart = orSearches[i];
                var orSearchPartPhrases = [];

                if (hasSearchMode('and')) {
                    var andSearches = orSearchPart.trim();
                    andSearches = andSearches.replace(/^\s*and\s+/gi, "");
                    andSearches = andSearches.replace(/\s+and\s*$/gi, "");
                    andSearches = andSearches.replace(/\sand\s/gi, " and ");
                    andSearches = andSearches.split(' and ');
                    for (var j = 0; j < andSearches.length; j += 1) {
                        var andSearchPart = andSearches[j];
                        orSearchPartPhrases.push(andSearchPart);
                    }
                } else {
                    var orSearchPartPhrases = strToPhrases(orSearchPart);
                    orSearchPartPhrases = orSearchPartPhrases.concat(orSearchPartPhrases);
                }

                var orSearchPartRegex = "";
                for (var j = 0; j < orSearchPartPhrases.length; j += 1) {
                    orSearchPartRegex += "(?=.*" + orSearchPartPhrases[j] + ")";
                }
                orSearchPartRegex += ".+";
                orSearchRegexes.push(orSearchPartRegex);
            }
            var searchRegex = orSearchRegexes.join('|');
            // console.log('searches=', searches);
            // console.log('searchRegex=', searchRegex);
            return searchRegex;
        }

        if (KRdt.searchOnEnter || KRdt.serverSide) {
            if (KRdt.overrideSearchInput) $('#' + id + '_filter input')
                .unbind();
            $('#' + id + '_filter input')
                .bind('keydown', function (e) {
                    if (e.keyCode != 13) return;
                    e.preventDefault(); //prevent form submit with enter input
                    // if not "serverSide" use regex search
                    if (!KRdt.serverSide) {
                        if (hasSearchMode('smart')) {
                            var searchValue = this.value;
                            jQdt.search(searchValue, false, true).draw();
                        } else if (hasSearchMode('exact')) {
                            var searchValue = $.fn.dataTable.util.escapeRegex(this.value);
                            jQdt.search(searchValue, false, false).draw();
                        } else {
                            var searchRegex = strToRegexStr(this.value);
                            jQdt.search(searchRegex, true, false).draw();
                        }
                    } else { // if "serverSide" use normal search
                        jQdt.search(this.value).draw();
                    }
                });
        }

        // only search on input if not "serverSide" or "serverSide" and "serverSideInstantSearch"
        if ((!KRdt.searchOnEnter && !KRdt.serverSide) ||
            (KRdt.serverSide && KRdt.serverSideInstantSearch)) {
            if (KRdt.overrideSearchInput) $('#' + id + '_filter input')
                .unbind();
            $('#' + id + '_filter input')
                .bind('input', function (e) {
                    if (!KRdt.serverSide) {
                        if (hasSearchMode('smart')) {
                            var searchValue = this.value;
                            jQdt.search(searchValue, false, true).draw();
                        } else if (hasSearchMode('exact')) {
                            var searchValue = $.fn.dataTable.util.escapeRegex(this.value);
                            jQdt.search(searchValue, false, false).draw();
                        } else {
                            var searchRegex = strToRegexStr(this.value);
                            jQdt.search(searchRegex, true, false).draw();
                        }
                    } else { // if "serverSide" use normal search
                        jQdt.search(this.value).draw();
                    }
                });
        }

    }

    dt.init = function (data) {
        for (var p in data)
            if (data.hasOwnProperty(p))
                this[p] = data[p];

        this.bindSearchOnEnter();

        var dtObj = global[this.id];

        //When page change or page length change, reset all rows' layer state 
        //and make them visible
        //Otherwise, hidden rows (with layer <=0) won't ever be shown
        //because all group rows are rerendered at init state and only show collapse icons
        //Page change or page length change event happens before row groups are rendered
        function resetRowLayerFunc(e, settings) {
            // console.log('page length changed')
            var rows = document.querySelectorAll('#' + this.id + ' tr');
            rows.forEach(function (row) {
                var layer = row.dataset.layer;
                if (layer && 1 * layer < 1) {
                    delete row.dataset.layer;
                    row.style.display = '';
                }
            })
        };
        dtObj.on('length.dt', resetRowLayerFunc.bind(this));
        dtObj.on('page.dt', resetRowLayerFunc.bind(this));

        if (data.rowDetailData) {
            var expandCollapseSelector = data.rowDetailIcon ?
                'td.details-control i' :
                (data.rowDetailSelector || 'tbody tr[role="row"]');
            dtObj.on('click', expandCollapseSelector, function () {
                var tr = $(this).closest('tr');
                var row = dtObj.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    if (data.rowDetailIcon)
                        this.classList.replace('fa-minus-square', 'fa-plus-square');
                } else {
                    // Open this row
                    var rowArr = row.data();
                    var rowData = {};
                    for (var i = 1; i < data.showColumnKeys.length; i += 1) {
                        var colIndex = data.fastRender ? i - 1 : i;
                        rowData[i] = rowData[data.showColumnKeys[i]] = rowArr[colIndex];
                    }
                    rowData['{rowDetailData}'] = rowArr['{rowDetailData}'];
                    row.child(data.rowDetailData(rowData)).show();
                    tr.addClass('shown');
                    if (data.rowDetailIcon)
                        this.classList.replace('fa-plus-square', 'fa-minus-square');
                }
            });
        }

        this.addEditButtonsListener(document.querySelector(`table#${this.id}`));

    }

    var KRDataTablesFunctions = (function () {
        return function () {
            for (var p in dt)
                if (dt.hasOwnProperty(p))
                    this[p] = dt[p];
        };
    })();

    var KRDataTables = function () { };
    KRDataTablesFunctions.call(KRDataTables.prototype);

    return {
        create: function (vq_data) {
            var krdt = new KRDataTables();
            krdt.init(vq_data);
            return krdt;
        }
    }
})(window);