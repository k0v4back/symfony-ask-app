var preview = document.getElementById('avatar');
var file_input = document.getElementById('user_settings_avatar')

window.previewFile  = function ()
{
    let file = file_input.files[0]
    let reader = new FileReader()

    reader.addEventListener('load', function (event)
    {
        preview.src = reader.result
    }, false)

    if (file)
    {
        reader.readAsDataURL(file)
    }
}