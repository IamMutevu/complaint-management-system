Dropzone.autoDiscover = false;    

$(function(){
    // const doka = Doka.create();
    var team = Doka.create({
        cropAspectRatioOptions: [
            {
                label: 'Team',
                value: '3:4'
            }
        ]
    });

    var user_doka = Doka.create({
        cropAspectRatioOptions: [
            {
                label: 'Square',
                value: '1:1'
            }
        ]
    });

    var gallery_doka = Doka.create({
        cropAspectRatioOptions: [
            {
                label: 'Gallery',
                value: '960:640'
            }
        ]
    });

    $.fn.initDropzone = function(){
        var id = $(this).attr('id');
        if ($(this.element).hasClass('single')){
          var limit = 1;
        } 
        else{
          var limit = null;
        }
        return new Dropzone("#"+id+"",{
            url: "/dropzone",
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            maxFiles: limit, 
            acceptedFiles: 'image/*,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword',
            dictDefaultMessage: 'Drop a file or click here to upload',
            dictRemoveFile: "Remove",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            transformFile: function(file, done){
              myDropZone = this;
                if (file.type === 'image/jpeg' || file.type === 'image/png') {
                    if (!$(this.element).hasClass('logo')) {
                        if ($(this.element).hasClass('square')) {
                            user_doka.edit(file).then(function (output) {
                                var blob = output.file;
                                myDropZone.createThumbnail(
                                    blob,
                                    myDropZone.options.thumbnailWidth,
                                    myDropZone.options.thumbnailHeight,
                                    myDropZone.options.thumbnailMethod,
                                    false,
                                    function (dataURL) {
                                        myDropZone.emit('thumbnail', file, dataURL);
                                        done(blob);
                                    }
                                ); 
                            });
                        }
                        else if ($(this.element).hasClass('team')) {
                            team.edit(file).then(function (output) {
                                var blob = output.file;
                                myDropZone.createThumbnail(
                                    blob,
                                    myDropZone.options.thumbnailWidth,
                                    myDropZone.options.thumbnailHeight,
                                    myDropZone.options.thumbnailMethod,
                                    false,
                                    function (dataURL) {
                                        myDropZone.emit('thumbnail', file, dataURL);
                                        done(blob);
                                    }
                                ); 
                            });
                        }
                        else if ($(this.element).hasClass('gallery')) {
                            gallery_doka.edit(file).then(function (output) {
                                var blob = output.file;
                                myDropZone.createThumbnail(
                                    blob,
                                    myDropZone.options.thumbnailWidth,
                                    myDropZone.options.thumbnailHeight,
                                    myDropZone.options.thumbnailMethod,
                                    false,
                                    function (dataURL) {
                                        myDropZone.emit('thumbnail', file, dataURL);
                                        done(blob);
                                    }
                                ); 
                            });
                        }
                        else {
                            doka.edit(file).then(function (output) {
                                var blob = output.file;
                                myDropZone.createThumbnail(
                                    blob,
                                    myDropZone.options.thumbnailWidth,
                                    myDropZone.options.thumbnailHeight,
                                    myDropZone.options.thumbnailMethod,
                                    false,
                                    function (dataURL) {
                                        myDropZone.emit('thumbnail', file, dataURL);
                                        done(blob);
                                    }
                                ); 
                            });
                        }
                    }
                    else {
                        myDropZone.createThumbnail(
                            file,
                            myDropZone.options.thumbnailWidth,
                            myDropZone.options.thumbnailHeight,
                            myDropZone.options.thumbnailMethod,
                            false,
                            function (dataURL) {
                                myDropZone.emit('thumbnail', file, dataURL);
                                done(file);
                            }
                        );
                    }   
                }
                else {
                    done(file);
                }
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="file[]" value="' + response.name + '" data-original-name="'+response.original_name + '" >')
            },
            removedfile: function(file) 
            {
                if (this.options.dictRemoveFile) {
                  return Dropzone.confirm("Are you sure you want to perform this action?", function() {
                    if(file.previewElement.id != ""){
                        var name = file.previewElement.id;
                    }else{
                        var name = file.name;
                    }
                    var original_name = $('input[name="file[]"][data-original-name="' + name + '"]').val();
                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      type: 'POST',
                      url: "/dropzone_delete",
                      data: {filename: original_name},
                      success: function (data){
                        file.previewElement.remove();
                            // alert(data.filename +" File has been successfully removed!");
                            $('input[name="file[]"][data-original-name="' + name + '"]').remove()
                        },
                        error: function(e) {
                            console.log(e);
                        }});
                });
              }       
          },            
      });
    };
});