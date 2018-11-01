<template>
        <main class="main">

            <div id="CAROSUEL">
                <b-carousel id="carousel1"
                            style="text-shadow: 1px 1px 2px #333;"
                            controls
                            indicators
                            background="#ababab"
                            :interval="4000"
                            img-width="1024"
                            img-height="480"
                            v-model="slide"
                            @sliding-start="onSlideStart"
                            @sliding-end="onSlideEnd"
                >

                <!-- Text slides with image -->
                <b-carousel-slide caption="First slide"
                                    text="Nulla vitae elit libero, a pharetra augue mollis interdum."
                                    img-src="https://picsum.photos/1024/480/?image=52"
                ></b-carousel-slide>

                <!-- Slides with custom text -->
                <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=54">
                    <h1>Hello world!</h1>
                </b-carousel-slide>

                <!-- Slides with image only -->
                <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=58">
                </b-carousel-slide>

                <!-- Slides with img slot -->
                <!-- Note the classes .d-block and .img-fluid to prevent browser default image alignment -->
                <b-carousel-slide>
                    <img slot="img" class="d-block img-fluid w-100" width="1024" height="480"
                        src="https://picsum.photos/1024/480/?image=55" alt="image slot">
                </b-carousel-slide>

                <!-- Slide with blank fluid image to maintain slide aspect ratio -->
                <b-carousel-slide caption="Blank Image" img-blank img-alt="Blank image">
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
                    eros felis, tincidunt a tincidunt eget, convallis vel est. Ut pellentesque
                    ut lacus vel interdum.
                    </p>
                </b-carousel-slide>

                </b-carousel>

                <!-- <p class="mt-4">
                Slide #: {{ slide }}<br>
                Sliding: {{ sliding }}
                </p> -->

            </div>
            <div>
                <br>
            <b-card-group columns>
                <b-card title="Card title that wraps to a new line"
                        img-src="https://placekitten.com/g/400/450"
                        img-fluid
                        img-alt="image"
                        img-top>
                    <p class="card-text">
                        This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit
                        longer.
                    </p>
                </b-card>
                <b-card header="Quote">
                    <blockquote class="blockquote mb-0">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                        <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                    </blockquote>
                </b-card>
                <b-card title="Title"
                        img-src="https://placekitten.com/500/350"
                        img-fluid
                        img-alt="image"
                        img-top>
                    <p class="card-text">
                        This card has supporting text below as a natural lead-in to additional content.
                    </p>
                    <small class="text-muted">Last updated 3 mins ago</small>
                </b-card>
                <b-card bg-variant="primary"
                        text-variant="white">
                    <blockquote class="card-blockquote">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                        </p>
                        <footer>
                            <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                        </footer>
                    </blockquote>
                </b-card>
                <b-card title="Title">
                    <p class="card-text">
                        This card has supporting text below as a natural lead-in to additional content.
                    </p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </b-card>
                <b-card img-src="https://picsum.photos/400/400/?image=41"
                        img-fluid
                        img-alt="image"
                        overlay>
                </b-card>
                <b-card img-src="https://picsum.photos/400/200/?image=41"
                        img-fluid
                        img-alt="image"
                        img-top>
                    <p class="card-text">
                        This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content
                        than the first.
                    </p>
                    <div slot="footer">
                        <small class="text-muted">Footer Text</small>
                    </div>
                </b-card>
            </b-card-group>
</div>

     
           
        </main>
</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        
        data(){
            return{
               slide: 0,
                sliding: null
            }
        },
        components:{
            Datepicker
        },
        
        computed:{},
        methods:{
            onSlideStart (slide) {
                this.sliding = true
            },
            onSlideEnd (slide) {
            this.sliding = false
            }
        },
       
    }
</script>
<style>
    .modal-content{
        width: 100% !important ;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important ;
        position: absolute !important ;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
