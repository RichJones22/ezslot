<template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Your downloaded files</div>

                    <div class="panel-body">
                        <table class="table table-bordered table-responsive">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>#</th>
                                    <th>File Name</th>
                                    <th>Download Date</th>
                                    <th>File Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>2017-08-trans.txt</td>
                                    <td>2017-08-01 05:00:00</td>
                                    <td>500 kb</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>2017-09-trans.txt</td>
                                    <td>2017-09-01 04:00:00</td>
                                    <td>1125 kb</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>2017-07-trans.txt</td>
                                    <td>2017-07-01 02:32:12</td>
                                    <td>4 MB</td>
                                </tr>
                            </tbody>
                        </table>
                        <dropZone id="VueDropzone" url="/foobar" v-on:vdropzone-success="showSuccess">
                            <!-- Optional parameters if any! -->
                            <input type="hidden" name="token" value="xxx">
                        </dropZone>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    let dropZone = require('vue2-dropzone');

    export default {
        data(){
            return{
            }
        },
        mounted() {
            console.log('home Component is ready.');
        },
        components: {
            dropZone
        },
        methods: {
            'showSuccess': function (file) {
                console.log('A file was successfully uploaded');
                console.log(file);
            }
        },
        computed: {
        }
    }
</script>
