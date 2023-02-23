@extends("layout")

@section('head')
<!--cdn-->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet"
    type="text/css" />
<!--scripts-->
<script type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
<!--style-->
<!--For text_editor-->
<link href="/assets/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<!--For bootstrap-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
@endsection

@section('content')
<div class="container">
    <form id="editor_form" action="/user/posts/post/add" method="POST">
        @csrf
        <div class="d-flex" style="@error('title') border-color:red; @enderror">
            <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-lg">Title</span>
                </div>
                <input name="title" id="input_title" type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-lg" placeholder="Enter title here">
            </div>
        </div>
        <label for="body"></label>
        <textarea name="body" id="editor_content" style="@error('body') border-color:red; @enderror">
                <p style="text-align: left;"><em>Body content goes here. Customize it however you like..<br></em></p>
            </textarea>

        @error('topic')
        <p class="text-red-500">Topic tag required!!</p>
        @enderror

        @error('body')
        <p class="text-red-500">Body content cannot be empty!</p>
        @enderror

        {{--tags will be appended here?--}}
        <div id="tag_list" name="tag_list"></div>
        <button name="submit_button" class="btn btn-primary mt-2" onsubmit="onSave()" type="submit">Submit</button>
    </form>
    <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-toggle="modal" data-target="#tag_modal">
        add tag
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-circle-fill" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z">
            </path>
        </svg>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="tag_modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Create custom tags</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Save">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="modal_add_input" type="text" class="form-control" placeholder="add tag"
                            aria-label="Tag name" aria-describedby="modal_add_button">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="modal_add_button"
                                onclick="addModalTags()">Add</button>
                        </div>
                    </div>
                    <input type="hidden" value="0" id="custom_tag_counter" />
                </div>
                <div id="custom-tag-list"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal_save_button"
                        onClick="saveModalTags()">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="application/javascript">
    const editor = new FroalaEditor('#editor_content', {
        fileMaxSize: 1024 * 1024 * 3,
        toolbarInline: false,
        imageUploadURL: 'https://luck-kindly-tuck.glitch.me/upload_image',
        fileUploadURL: 'https://luck-kindly-tuck.glitch.me//upload_file'
    });


    editor.opts.events['image.removed'] = function (e, editor, $img) {
        $.ajax({
            // Request method.
            method: 'POST',

            // Request URL.
            url: 'https://luck-kindly-tuck.glitch.me/delete_image',

            // Request params.
            data: {
                src: $img.attr('src')
            }
        })
            .done(function (data) {
                console.log('Image was deleted');
            })
            .fail(function (err) {
                console.log('Image delete problem: ' + JSON.stringify(err));
            })
    }


    editor.opts.events['file.unlink'] = function (e, editor, file) {
        $.ajax({
            // Request method.
            method: 'POST',

            // Request URL.
            url: '/delete_file',

            // Request params.
            data: {
                src: file.getAttribute('href')
            }
        })
            .done(function (data) {
                console.log('File was deleted');
            })
            .fail(function (err) {
                console.log('File delete problem: ' + JSON.stringify(err));
            })
    }

</script>
<script>

    function onSave() {
        const tags = [];
        if ($('#tag_list').children().length > 0) {
            $("#tag_list").children().each(function (index) {
                tags.push({ value: $(this).html(), name: $(this).attr("id") });
            });
        }

    }


    function saveModalTags() {

        const tagListElement = document.getElementById("tag_list")

        //adds each custom tag to selected list of tags
        $(".custom").each((index, element) => {
            element.classList.remove('custom');
            //replaces on click function to the one used for default selected tags
            element.onclick = (event) => onClick(event);
            tagListElement.appendChild(element);
        });

        //remove custom made tags from modal body.
        $("#custom-tag-list").empty();
    }

    function addModalTags() {
        //adds modal tag to list.
        const value = $("#modal_add_input").val();
        let counter = $("#custom_tag_counter").attr('value');

        let n = parseInt(counter, 10) //converts string to base 10 integer
        n++; //adds one

        //update counter
        setCounter(n);



        //if value is not undefined or empty string.
        if (!(value === "" && value === "undefined")) {

            $("#modal_add_input").val("") //reset it to empty

            $("#custom-tag-list")
                .append(`<a id="tag_${counter}" onclick="onClick(event)" name="tag_${counter}"  href='#editor' class="badge badge-info ml-2 tags custom selected" >${value}</a>`)
        }

    }

    function modalTagDelete(event) {
        //delete custom tag.
        const { parentNode } = event.target;

        parentNode.removeChild(event.target);
        let counter = $("#custom_tag_counter").attr('value');
        let n = parseInt(counter, 10) //converts string to base 10 integer
        if (n !== 0) {
            n--; //decreases counter
            setCounter(n)
        }
    }






    function onClick(event) {
        const { id } = event.target;
        const tag_element = $(`#${id}`);
        //check if item has been selected
        if (tag_element.hasClass("selected")) { //remove it from tag list.
            //toggles selected and adds to the bottom container
            tag_element.toggleClass("selected");
            //clone does not have selected as a class
            tag_element.clone(true).appendTo(".container");
            //remove corresponding input.
            console.log(`input[element_id=${id}]`);
            $(`input[element_id=${id}]`).remove();
            tag_element.remove(); //remove element


        } else { //add to the tag list
            tag_element.toggleClass('selected');
            // alternative const clone = $(`#${name}`).clone(false, true); $('.container').append(clone);
            tag_element.clone(true).appendTo("#tag_list");

            const index = id.replace('tag_', '');

            $('<input/>').attr('name', `tags[]`)
                .attr('type', 'hidden')
                .attr('value', tag_element.html())
                .attr('element_id', name)
                .appendTo("#editor_form");



            //clones deep includes events and attaches to tag_list.
            tag_element.remove(); //removed from dom.
        }
    }



    const tag_data = {!! json_encode($tag_data)!!}

    //generate from tags available - popular
    if (typeof tag_data != "undefined" && tag_data.length > 0) {
        setCounter(tag_data.length);
        tag_data.map(({ tag }, index) => $('.container').append(`<a id='tag_${index}' name='tag_${index}' href='#editor' onclick="onClick(event)" class='badge badge-info ml-2 tags'>${tag}</a>`))

        //add default tag
    } else {
        //default tag list
        const data = ["Self improvement/Self-Hypnosis",
            "Health & Fitness for Busy People",
            "Language Learning Blogs",
            "How to Travel on a Budget (Best hotel deals. Car rental. Trip advice.)",
            "Writing Style",
            "Rescued Animals",
            "Personal Development (Passions & Ambition Pursuing)",
            "Social Dynamics & Communication Skills",
            "Working in Uncommon Fields of Expertise While Location Independence",
            "Self Defense"];
        //sets counter to size of current tags
        setCounter(data.length)
        data.map((elem, index) =>
            $('.container').append(`<a id='tag_${index}' onclick="onClick(event)" name='tag_${index}' href='#editor' class='badge badge-info ml-2 tags'>${elem}</a>`)
        )
    }


    function setCounter(value) {
        $("#custom_tag_counter").attr('value', value.toString());
    }
</script>
{{--
<script src="/assets/js/create_post.js" type="application/javascript" /> --}}
@endsection