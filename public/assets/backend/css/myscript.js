

let addFolder = () => {
    let folderName = document.getElementById('folder_create').value;
    let folde = document.getElementById('folder_create');
    const container = document.getElementById('addFolderHere');

    // Check if the folderName is not empty
    if (folderName.trim() === "") {
        console.log("Folder name cannot be empty.");
        return;
    }


    console.log(folderName);
    const newFolderHTML = `
        <div class="col-lg-2">
            <div class="folder_page">
                <div class="folder_icon">
                    <a href="Managment.html"><i class="fas fa-folder"></i></a>
                    <h5>${folderName}</h5>
                </div>
                <div class="three_dot">
                    <i class="fas fa-ellipsis-v"></i>
                </div>
            </div>
        </div>
    `;
    container.innerHTML += newFolderHTML;

};




$(document).ready(function () {

    $(".forgetopen").click(function () {
        if ($("#forget").is(':visible')) {
            $('#forget').hide();
            $('#login').show();
        } else {
            $('#login').hide();
            $('#forget').show();
        }
    })

    $("#fm").select(function()
    {
        let x = $("#fm").select().val()
        console.log(x)
   })
   
});



var loadFile = function (event)
{
    var image = document.getElementById("output");
    image.src = URL.createObjectURL(event.target.files[0]);
};

// let formbehaviours = (event) =>
// {
//     event.preventDefault();
//     console.log('hello me dde3es,e')
// }
