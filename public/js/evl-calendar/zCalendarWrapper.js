/* ===================================================
 * zCalendarWrapper.js v0.2.0
 * https://github.com/evolic/zf2-tutorial/blob/calendar/public/js/evl-calendar/zCalendarWrapper.js
 * ===================================================
 * Copyright 2013 Tomasz Kuter
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

/**
 * jQuery Fullcalendar wrapper class
 *
 * Class based on the JavaScript OOP example available at:
 * http://phrogz.net/JS/classes/OOPinJS.html
 *
 * @author Tomasz Kuter <evolic_at_interia_dot_pl>
 * @version v0.2.0
 * @param {Array} config
 */

function zCalendarWrapper(config) {
    this.constructor.population++;
    // ************************************************************************ 
    // PRIVATE VARIABLES AND FUNCTIONS 
    // ONLY PRIVELEGED METHODS MAY VIEW/EDIT/INVOKE 
    // *********************************************************************** 

    /**
     * jQuery FullCalendar container e.g. '#calendar'
     * @private
     */
    var container = config.container;
    delete config.container;

    var isAdmin = config.isAdmin;
    delete config.isAdmin;

    var isLoggedIn = config.isLoggedIn;
    delete config.isLoggedIn;

    var courtId = config.courtId;
    delete config.courtId;

    /**
     * List of urls used to get/update/delete event(s)
     * For example:
     * {
     *   get: '/events/get',
     *   add: '/events/add',
     *   update: '/events/update',
     *   erase: '/events/delete'
     * }
     * @private
     */
    var api = config.api;
    delete config.api;

    var locales = config.locales;
    delete config.locales;

    function isOverlapping(event){
        var array = calendar.fullCalendar('clientEvents');
        for(i in array){
            if(!(array[i].start >= event.end || array[i].end <= event.start)){
                return true;
            }
        }
        return false;
    }

    /**
     * @private
     */


    var defaults = {
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        selectable: true,
        selectHelper: true,
        firstDay: 1, // start week from Monday
        root: 'events',
        success: 'success',
        events: api.get,
        timeFormat: 'H:mm', // uppercase H for 24-hour clock
        axisFormat: 'H:mm',
        slotMinutes: 15,
        snapMinutes: 15,
        defaultEventMinutes: 45,
        select: function (startDate, endDate, allDay, jsEvent, view) {
            if (isLoggedIn==1) createEvent(startDate, endDate, allDay, jsEvent, view, courtId);
            else calendar.fullCalendar('unselect');
        },
        eventDrop: function (event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
            if (isAdmin==1) updateEvent(event, revertFunc);
            else revertFunc();
        },
        eventResize: function (event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {
            if (isAdmin==1) updateEvent(event, revertFunc);
            else revertFunc();
        },
        eventClick: function (event, jsEvent, view) {
            if (isAdmin==1) clickEvent(event);
            else revertFunc();
        },
        loading: function (bool) {
            if (bool) {
                $('#loading').show();
                //$('#calendar').hide();
            }
            else {
                $('#loading').hide();
                //$('#calendar').show();
            }
        }
    };

    /**
     * @private
     */
    var cfg = defaults;
    $.extend(true, cfg, config);

    /**
     * @private
     */
    var format = "yyyy-MM-dd HH:mm:ss";
    /**
     * jQuery FullCalendar instance
     * @private
     */
    var calendar = $(container).fullCalendar(cfg);

    /**
     * @private
     */
    function createEvent(startDate, endDate, allDay, jsEvent, view, courtId) {
        var ts = new Date().getTime();

        var check = $.fullCalendar.formatDate(startDate,'yyyy-MM-dd HH:mm');
        var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd HH:mm');
        if(check < today || isOverlapping({start: startDate, end: endDate}))
        {
            calendar.fullCalendar('unselect');
        }
        else {
        bootbox.confirm(translate(
            "Confirmez vous la réservation pour le " + $.fullCalendar.formatDate(startDate, "dd-MM-yyyy")
                + " de<br />"
                + "<strong>" + $.fullCalendar.formatDate(startDate, "HH:mm") + "</strong>"
                + "<br />à<br />"
                + "<strong>" + $.fullCalendar.formatDate(endDate, "HH:mm") + "</strong>"
        ), function (confirmed) {
            if (confirmed) {
                startDate = $.fullCalendar.formatDate(startDate, format);
                endDate = $.fullCalendar.formatDate(endDate, format);
                console.log("court is" + courtId)
                $.ajax({
                    url: api.add,
                    data: {
                        start: startDate,
                        end: endDate,
                        ts: ts,
                        courtId: courtId
                    },
                    type: "POST",
                    success: function (response) {
                        if (response.success) {
                            bootbox.confirm("Le prix s'élève à </br><strong>" + response.calculatedPrice +
                                ".-</strong><br/>Confirmer la réservation?<br/>"
                                ,function(confirmed)
                                {
                                    if(confirmed)
                                    { 
                                        console.log("Réservation ajoutée!");
                                        var events = calendar.fullCalendar('clientEvents');

                                        for (var i in events) {
                                            if (typeof(events[i].ts) !== 'undefined' && events[i].ts == response.ts) {
                                                events[i].id = parseInt(response.id);
                                                console.log(events[i])
                                                delete events[i].ts;
                                            }
                                        }
                                    calendar.fullCalendar('renderEvent', {
                                        title: "Réservé!!",
                                        start: startDate,
                                        end: endDate,
                                        allDay: allDay,
                                        ts: ts,
                                        backgroundColor: '#33B5E5'
                                    }, true); // make the event "stick"
                                    }
                                    else {                     
                                        calendar.fullCalendar('unselect');
                                    }
                                });
                        } else {
                            bootbox.alert(response.message, function () {
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        bootbox.alert('Error occured during saving event in the database', function () {
                        });
                    }
                });
            }
        });
        calendar.fullCalendar('unselect');
    }
}

    /**
     * @private
     */
    function updateEvent(event, revertFunc, skipConfirm, report) {

        var ts = new Date().getTime();
        event.ts = ts;

        if (typeof(skipConfirm) === 'undefined') {
            skipConfirm = false;
        }
        if (typeof(report) === 'undefined') {
            report = false;
        }
        var check = $.fullCalendar.formatDate(event.start,'yyyy-MM-dd');
        var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd');
        if(check < today)
        {
            calendar.fullCalendar('unselect');
            revertFunc();
        }
        else {

        // TODO : montrer la différence entre old et new hour dans le text du dialog
        bootbox.confirm(translate('Cela convient-il?<br />' + event.start.getTimestamp() + '<br />à<br />' + event.end.getTimestamp()), function (result) {
            if (!skipConfirm && !result) {
                revertFunc();
            } else {
                $.ajax({
                    url: api.update,
                    data: {
                        id: event.id,
                        start: event.start.getTimestamp(),
                        end: event.end.getTimestamp(),
                        ts: ts
                    },
                    type: "POST",
                    success: function (response) {
                        if (response.success) {
                            bootbox.alert(response.message, function () {
                            });
                            var events = calendar.fullCalendar('clientEvents');

                            for (var i in events) {
                                if (typeof(events[i].ts) !== 'undefined' && events[i].ts == response.ts) {
                                    delete events[i].ts;

                                    if (report) {
                                        // Reports changes to an event and renders them on the calendar
                                        calendar.fullCalendar('updateEvent', events[i]);
                                    }
                                }
                            }
                        } else {
                            bootbox.alert(response.message, function () {
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        bootbox.alert('Error occured during saving event in the database', function () {
                        });
                    }
                });
            }
        });
    }
}

    /**
     * @param {Array} event
     * @private
     */
    function deleteEvent(event) {
        var ts = new Date().getTime();
        event.ts = ts;

        $.ajax({
            url: api.erase,
            data: {
                id: event.id,
                ts: ts
            },
            type: "POST",
            success: function (response) {
                if (response.success) {
                    bootbox.alert(response.message, function () {
                    });
                    var events = calendar.fullCalendar('clientEvents');

                    for (var i in events) {
                        if (typeof(events[i].ts) !== 'undefined' && events[i].ts == response.ts) {
                            delete events[i].ts;
                            calendar.fullCalendar("removeEvents", events[i]._id);
                        }
                    }
                } else {
                    bootbox.alert(response.message, function () {
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                bootbox.alert("Une erreur est survenue lors de l'enregistrement dans la base de donnée!", function () {
                });
            }
        });
    }

    /**
     * @param {Array} event
     * @private
     */
    function editEvent(event) {
        bootbox.prompt(translate('Event Title:'), translate('Cancel'), translate('OK'), function (title) {
            if (title) {
                event.title = title;
                updateEvent(event, function () {
                }, true, true);
            }
        }, event.title);
    }

    /**
     * @param {Array} event
     * @private
     */
    function clickEvent(event) {

        bootbox.dialog({
            message: "Réservation de<br/>" + event.start.getTimestamp() + "<br/>à<br/>" + event.end.getTimestamp() + "",
            title: "Supprimer une réservation",
            buttons: {
                danger: {
                    label: "Supprimer",
                    className: "btn-danger",
                    callback: function () {
                        deleteEvent(event)
                    }
                }
            },
            onEscape: function () {
            }
        });
    }

    /**
     * @private
     */
    function translate(text) {
        if (typeof(locales[text]) !== 'undefined') {
            return locales[text];
        } else {
            return text;
        }
    }

    // ************************************************************************ 
    // PRIVILEGED METHODS 
    // MAY BE INVOKED PUBLICLY AND MAY ACCESS PRIVATE ITEMS 
    // MAY NOT BE CHANGED; MAY BE REPLACED WITH PUBLIC FLAVORS 
    // ************************************************************************ 

    /**
     * @public
     */
    this.getCalendar = function () {
        return calendar;
    }

    // ************************************************************************ 
    // PUBLIC PROPERTIES -- ANYONE MAY READ/WRITE 
    // ************************************************************************ 

} 