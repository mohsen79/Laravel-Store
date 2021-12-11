@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card col-lg-8 offset-lg-2">
            <div class="card-header">
                <h3>{{ $product->title }}</h3>
            </div>
            <div class="card-body">
                <img src="{{ $product->image }}" alt="" class="rounded" style="width:100%;height:50vh">

                <h3 class="m-1">attributes :</h3>
                @foreach ($product->attributes as $attribute)
                    <p class="m-1"> {{ $attribute->name }} :
                        {{ $attribute->pivot->value->value }} <br></p>
                @endforeach

                @auth
                    @if (Route::has('add.to.cart'))
                        <form action="{{ route('add.to.cart', $product->id) }}" method="post">
                            @csrf
                            <button class="btn btn-sm btn-outline-info mt-2 float-right">Add to Cart</button>
                        </form>
                    @endif
                    @if (Route::has('admin.register.comment'))
                        <span class="btn btn-sm btn-primary mt-2" data-toggle="modal" data-target="#sendComment" data-id="0"
                            data-type="product">register new comment</span>
                    @endif
                @endauth
                @guest
                    <div class="alert alert-warning">if you did not log in,please first log in to insert comment</div>
                @endguest
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="sendComment">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">send comment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (Route::has('admin.register.comment'))
                        <form action="{{ route('admin.register.comment') }}" method="post" id="CommentForm">
                            @csrf
                            <input type="hidden" name="commentable_id" value="{{ $product->id }}">
                            <input type="hidden" name="commentable_type" value="{{ get_class($product) }}">
                            <input type="hidden" name="parent_id" value="0">

                            <div class="form-group">
                                <label for="message-text" class="col-form-label">your comment:</label>
                                <textarea class="form-control" name="comment" id="message-text"></textarea>
                                {{-- <div id="editor"></div>
                                <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
                                <script>
                                    ClassicEditor
                                        .create(document.querySelector('#editor'))
                                        .catch(error => {
                                            console.error(error);
                                        });
                                </script> --}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                                <button type="submit" class="btn btn-primary">reply</button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
    @if (Route::has('admin.coments'))
        <div class="container mt-3">
            @include('comment::comment',['comments' => $comments->where('parent_id',0)->where('approved',1)])
        </div>
    @endif
    @if(Module::isEnable('Gallery'))       
     @if ($product->gallery->pluck('image')->count())
            <div class="all">
                <div class="box">
                    <div class="slide">
                        @foreach ($product->gallery as $img)
                            <div class="img"><img src="{{ $img->image }}">
                                <div class="back">
                                    <p class="m-2">{{ $img->alt }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="next"></div>
                <div class="prev"></div>
            </div>
        @endif
    @endif
    <script>
        $('#sendComment').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var subject_id = button.data('id'); // Extract info from data-* attributes
            var subject_type = button.data('type'); // Extract info from data-* attributes
            let parent_id = button.data('id');

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            // modal.find('.modal-body #subject_id').val(subject_id)
            // modal.find('.modal-body #subject_type').val(subject_type)
            modal.find('input[name="parent_id"]').val(parent_id);
        });
        $(document).ready(function() {
            $('.next').click(function() {
                var slide = $('.slide');
                slide.animate({
                    left: '0%'
                }, 500, function() {
                    slide.css('left', '-100%');
                    $('.img').first().before($('.img').last());
                });
            });
            $('.prev').click(function() {
                var slide = $('.slide');
                slide.animate({
                    left: '-200%'
                }, 500, function() {
                    slide.css('left', '-100%');
                    $('.img').last().after($('.img').first());
                });
            });
        });

    </script>
    <style>
        .all {
            height: 80vh;
            background: #8c8c8c;
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 1124px;
            height: 550px;
            overflow: hidden;
        }

        .slide {
            width: 500%;
            height: 100%;
            position: relative;
            left: -100%;
        }

        .img {
            width: calc(100%/5);
            height: 100%;
            float: left;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .img img {
            width: 100%;
            height: 100%;
        }

        .next {
            border-top: 2px solid black;
            border-right: 2px solid black;
            position: absolute;
            padding: 1.5%;
            right: 5%;
            transform: rotate(45deg);
            cursor: pointer;
        }

        .prev {
            border-top: 2px solid black;
            border-left: 2px solid black;
            position: absolute;
            padding: 1.5%;
            left: 5%;
            transform: rotate(-45deg);
            cursor: pointer;
        }

        .back {
            background: rgba(0, 0, 0, 0.5);
            width: 1122px;
            height: 50px;
            color: white;
            position: absolute;
            margin-top: 500px;
        }

    </style>
@endsection
