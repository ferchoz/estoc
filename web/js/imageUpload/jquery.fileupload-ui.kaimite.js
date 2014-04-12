/*
 * jQuery File Upload User Interface Plugin 5.0.12
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://creativecommons.org/licenses/MIT/
 */

/*jslint nomen: false, unparam: true, regexp: false */
/*global window, document, URL, webkitURL, FileReader, jQuery */

(function ($) {
    'use strict';
    

    // The UI version extends the basic fileupload widget and adds
    // a complete user interface based on the given upload/download
    // templates.
    $.widget('blueimpUIKaimite.fileupload', $.blueimpUI.fileupload, {
        
        options: {
      // If it's not a multiple upload, choose a file wille delete the old one
      singleUploadReplaceOld      : true,
      
      // Delete file confirmation message
      // null if you don't want to ask confirmation
      confirmDeleteFileMessage    : 'Voulez-vous vraiment supprimer ce fichier ?',
      
      // Delete all files confirmation message
      // null if you don't want to ask confirmation
      confirmDeleteAllFilesMessage  : 'Voulez-vous vraiment supprimer tous les fichiers ?',
      
      // By default, files added to the widget are uploaded as soon
            // as the user clicks on the start buttons. To enable automatic
            // uploads, set the following option to true:
            autoUpload: true,
      
      add: function (e, data) {
        var that = $(this).data('fileupload');
        
        //--> Test si le fichier remplace le dernier fichier
        if ( that._isMultiple() == false ) {
          var that    = $(this).data('fileupload'),
            filesList   = that.element.find('.files');
          filesList.find('.delete button').click();
        }

              that._adjustMaxNumberOfFiles(-data.files.length);
              data.isAdjusted = true;
              data.isValidated = that._validate(data.files);
              data.context = that._renderUpload(data.files)
                  .appendTo($(this).find('.files')).fadeIn(function () {
                      // Fix for IE7 and lower:
                      $(this).show();
                  }).data('data', data);
              if ((that.options.autoUpload || data.autoUpload) &&
                      data.isValidated) {
              data.jqXHR = data.submit();
              }
          },
  
            // Callback for successful uploads:
            done: function (e, data) {
                var that = $(this).data('fileupload');
        if (data.context) {
          data.context.each(function (index) {
            var file = ($.isArray(data.result) && data.result[index]) || {error: 'emptyResult'};

            if (file.error) {
              that._adjustMaxNumberOfFiles(1);
            }
            $(this).fadeOut(function () {
              that._renderDownload([file])
                .css('display', 'none')
                .replaceAll(this)
                .fadeIn(function () {
                  // Fix for IE7 and lower:
                  $(this).show();
                });
            });
          });
        } else {
          alert("Contacter le webmaster !!!");
          that._renderDownload(data.result)
            .css('display', 'none')
            .appendTo($(this).find('.files'))
            .fadeIn(function () {
              // Fix for IE7 and lower:
              $(this).show();
            });
        }
            },
            // Callback for file deletion:
            destroy: function (e, data) {
        var that    = $(this).data('fileupload');
        //--> Test si Click sur DeleteAll
        if ( typeof e.originalEvent.originalEvent == "undefined" ) {
          that._deleteTheFile(data, that);
        } else {
          if ( that.options.confirmDeleteFileMessage !== null ) {
            if ( confirm( that.options.confirmDeleteFileMessage ) == true ) {
              that._deleteTheFile(data, that);
            } 
          } else {
            that._deleteTheFile(data, that);
          }
              }
      }
        },

    _addThefile: function (e, data) {
      var that = $(this).data('fileupload');
            that._adjustMaxNumberOfFiles(-data.files.length);
            data.isAdjusted = true;
            data.isValidated = that._validate(data.files);
            data.context = that._renderUpload(data.files)
                .appendTo($(this).find('.files')).fadeIn(function () {
                    // Fix for IE7 and lower:
                    $(this).show();
                }).data('data', data);
            if ((that.options.autoUpload || data.autoUpload) &&
                    data.isValidated) {
            data.jqXHR = data.submit();
            }
    },

    _deleteTheFile: function (data, fileupladObject) {
      if (data.url) {
        var urlParts  = data.url.split("file="),
          fileName  = urlParts[1];
        $.ajax(data)
          .success(function () {
            fileupladObject._adjustMaxNumberOfFiles(1);
            $(this).fadeOut(function () {
              $(this).remove();
            });
          });
      } else {
        data.context.fadeOut(function () {
          $(this).remove();
        });
      }
    },

    _initFileUploadButtonBar: function () {
            var fileUploadButtonBar   = this.element.find('.fileupload-buttonbar'),
                filesList         = this.element.find('.files'),
                ns            = this.options.namespace,
        that          = this;
            
      //--> Add CSS for the control bar
      fileUploadButtonBar.addClass('ui-widget-header ui-corner-top');
            
      //--> Choose file button
      this.element.find('.fileinput-button').each(function () {
                var fileInput = $(this).find('input:file').detach();
                $(this).button({icons: {primary: 'ui-icon-plusthick'}})
                    .append(fileInput);
            });

      //--> Start all upload button
            fileUploadButtonBar.find('.start')
                .button({icons: {primary: 'ui-icon-circle-arrow-e'}})
                .bind('click.' + ns, function (e) {
                    e.preventDefault();
                    filesList.find('.start button').click();
                });

      //--> cancel all upload button
            fileUploadButtonBar.find('.cancel')
                .button({icons: {primary: 'ui-icon-cancel'}})
                .bind('click.' + ns, function (e) {
                    e.preventDefault();
                    filesList.find('.cancel button').click();
                });

      //--> Delete all files button
            fileUploadButtonBar.find('.delete')
                .button({icons: {primary: 'ui-icon-trash'}})
                .bind('click.' + ns, function (e) {
                    e.preventDefault();
          //--> Test if you want to confirm the delete action
          if (that.options.confirmDeleteAllFilesMessage !== null) {
            if ( confirm(that.options.confirmDeleteAllFilesMessage) == true ) {
              filesList.find('.delete button').click();
            }
          } else {
            filesList.find('.delete button').click();
          }
                });
        },
    
    _isMultiple: function () {
      var isMultiple = this.element.find("input[type='file']").attr('multiple');
      return typeof isMultiple == "undefined" ? false : true;
    }
    });

}(jQuery));