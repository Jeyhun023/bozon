Dropzone.autoDiscover = false;
var input = $("#images");
let oldV, newV;
$('#kt_dropzone_1').dropzone({
    url: fileUrl, // Set the url for your upload script location
    paramName: "file", // The name that will be used to transfer the file
    maxFiles: 10,
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    acceptedFiles: "image/*",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    accept: function(file, done) {
        done();
    },
    init: function() {
        this.on("success", function(file, response) {
            oldV = input.val();
            newV = response.data;
            if (oldV != '') {
                input.val(oldV + ',' + newV);
            } else {
                input.val(response.data);
            }
        })
    },
});

