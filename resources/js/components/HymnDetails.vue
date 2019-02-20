<template>
    <div class="container-fluid mt--7">
        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Hymn Record</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#!" class="btn btn-sm btn-primary" v-on:click="newVerse()">New Verse</a>
                                <a href="#!" class="btn btn-sm btn-success" v-on:click="addChorus()">Add Chorus</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" v-if="uploadProcessed || hymn.enabled">
                            Success!
                            <span>This hymn has been processed successfully.</span>
                        </div>
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            Error!
                            <span>{{errors.join(",")}}</span>
                        </div>
                        <div class="alert alert-warning" v-if="hymn.disabled">
                            Alert!
                            <span>This Record has been disabled</span>
                        </div>
                        <form>
                            <h6 class="heading-small text-muted mb-4">Hymn information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Title</label>
                                            <input
                                                type="text"
                                                id="input-username"
                                                v-model="hymn.title"
                                                class="form-control form-control-alternative"
                                                placeholder="Title"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-first-name">Extra</label>
                                            <input
                                                type="text"
                                                id="input-first-name"
                                                v-model="hymn.extra"
                                                class="form-control form-control-alternative"
                                                placeholder="First name"
                                                value
                                            >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-last-name">Number</label>
                                            <input
                                                type="text"
                                                id="input-last-name"
                                                v-model="hymn.number"
                                                class="form-control form-control-alternative"
                                                placeholder="Last name"
                                                v-on:input="checkHymnNumber()"
                                                value
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span>Verses</span>
                            <hr class="my-4">
                            <!-- Description -->
                            <div v-if="hymn.chorus != '' || isAddChorus">
                                <h6 class="heading-small text-muted mb-4">
                                    Chorus
                                    <a v-on:click="deleteChorus()" class="small del" style="float: right;">
                                        <i class="fa fa-times"></i> Delete
                                    </a>
                                </h6>

                                <div class="pl-lg-4">
                                    <div class="form-group">
                                        <wysiwyg v-model="hymn.chorus"/>
                                    </div>
                                </div>
                            </div>
                            <div v-for="(verse,index) in hymn.verses">
                                <h6 class="heading-small text-muted mb-4">
                                    Verse {{index + 1}}
                                    <a
                                        v-on:click="deleteHymn(index)"
                                        class="small del"
                                        style="float: right;"
                                    >
                                        <i class="fa fa-times"></i> Delete
                                    </a>
                                </h6>

                                <div class="pl-lg-4">
                                    <div class="form-group">
                                        <wysiwyg v-model="hymn.verses[index]"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row right--2" style="float: right;">
                                <div class="col-lg-12 right--1" id="button_submit">
                                    <a href="#button_submit" class="btn btn-danger" v-on:click="disable()">
                                        <span v-if="!disableProcessing && !hymn.disabled">Disable</span>
                                        <span v-if="disableProcessing">Disabling  <i class="fa fa-spinner"></i></span>
                                        <span v-if="hymn.disabled">Disabled</span>
                                    </a>
                                    <a class="btn btn-facebook" href="#button_submit" v-on:click="upload()">
                                        <span v-if="uploadProcessing == 0 && !hymn.enabled">Upload Hymn</span>
                                        <span v-if="uploadProcessing == 1">Processing</span>
                                        <span v-if="uploadProcessing == 2 || hymn.enabled">Processed</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-sm-2 order-lg-2 text-center" style="padding:23px;">
                            <a href="" class="btn btn-sm btn-primary" v-on:click="prev()">
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-3 order-lg-2 text-center">
                            <div class="card-profile-image" style="padding-top:23px;">
                                <h2>Hymn Info</h2>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-2 order-lg-2 text-center" style="padding:23px;">
                            <a href="" class="btn btn-sm btn-success" v-on:click="next()">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body pt-0 pt-md-4">
                        <div class="text-center">
                            <h3>
                                {{hymn.title}}
                                <br>
                                <span class="font-weight-light">Hymn Number {{hymn.number}}</span>
                            </h3>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>
                                {{hymn.extra}}
                            </div>

                            <hr class="my-4">
                            <code v-if="hymn.chorus != '' || isAddChorus" style="display: inline;">
                                <span style="color: #0a0c0d;">Chorus</span>
                                <p v-html="hymn.chorus"></p>
                            </code>
                            <code v-for="(verse,index) in hymn.verses" style="display: inline;">
                                <span style="color: #0a0c0d;">Verse {{index + 1}}</span>
                                <p v-html="hymn.verses[index]"></p>
                            </code>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-sm-6 order-lg-2 text-center" style="padding:23px;">
                            <a href="" class="btn btn-sm btn-primary" v-on:click="prev()">
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                        <div class="col-lg-6 col-sm-2 order-lg-2 text-center" style="padding:23px;">
                            <a href="" class="btn btn-sm btn-success" v-on:click="next()">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss">
    @import "~vue-wysiwyg/dist/vueWysiwyg.css";

    .del:hover {
        cursor: pointer;
    }
</style>
<script>
    import axios from "axios";
    export default {
        mounted() {
            this.$events.listen("newRecord", eventData => console.log("hi"));
            this.axios = axios.create({
                headers: {'apiToken': authToken}
            });
            this.getHymn();
        },
        data: function () {
            return {
                message: "Hi Bro",
                hymn: {
                    title: "",
                    number: "",
                    extra: "",
                    chorus: "",
                    enabled: false,
                    disabled: false,
                    verses: []
                },
                axios: null,
                errors: [],
                isAddChorus: false,
                status: 0,
                uploadProcessing: 0,
                uploadProcessed: false,
                disableProcessing: false,
                isValidHymn : 0,
                id: 0
            };
        },
        methods: {
            getHymn: function () {
                let id = this.$route.params.id;
                this.id = id;
                this.axios
                    .get("/api/get/" + id)
                    .then(response => {
                        let data = response.data.data;
                        this.hymn.title = data.title;
                        this.hymn.extra = data.extra;
                        this.hymn.enabled = data.enabled;
                        this.hymn.disabled = data.disabled;
                        this.hymn.number = data.number;
                        this.processVerses(data.data);
                    })
                    .catch(error => {
                        this.status = 2;
                        this.errors.push("Error in processing records");
                    });
            },
            processVerses: function (data) {
                let content = JSON.parse(data);
                for (let key in content) {
                    if (content.hasOwnProperty(key)) {
                        //console.log(key);
                        if (key.toLowerCase() == "egbe") {
                            this.hymn.chorus = content[key];
                            continue;
                        }
                        this.hymn.verses.push(content[key]);
                    }
                }
            },
            checkHymnNumber: function () {
                this.errors = [];
                    this.axios.get('/api/hymn/'+this.hymn.number).then(res => {
                        if(res.data.data != null ){
                            this.errors.push("This hymn has been processed previously")
                        }
                    }).catch(error => {
                        this.isValidHymn = -1;
                    })
            },
            deleteHymn: function (i) {
                console.log(i);
                this.hymn.verses.splice(i, 1);
            },
            newVerse: function () {
                this.hymn.verses.push("");
            },
            addChorus: function () {
                if (this.isAddChorus) {
                    return;
                }
                this.isAddChorus = true;
            },
            deleteChorus: function () {
                this.hymn.chorus = "";
                this.isAddChorus = false;
            },
            upload: function (e) {
                if (this.uploadProcessed || this.hymn.enabled || this.hymn.disabled) {
                    return;
                }

                this.uploadProcessing = 1;
                let data = {hymn: this.hymn, record_id: this.id};
                this.axios
                    .post("/api/hymn/create-hymn", data)
                    .then(response => {
                        let responseData = response.data;
                        if (responseData.status == 0) {
                            this.errors.push(responseData.message);
                            this.uploadProcessing = 0;
                            return;
                        }
                        this.uploadProcessing = 2;
                        this.uploadProcessed = true;
                        this.hymn.enabled = true;
                        this.$events.fire('reloadStats');
                    })
                    .catch(error => console.log(error));
            },
            disable: function () {
                if (this.hymn.disabled == true || this.hymn.enabled) {
                    return;
                }
                let data = {'id': this.id};
                this.axios.post('/api/disable', data).then((response)=> {
                    let data = response.data;
                    if (data.status == 1) {
                        this.hymn.disabled = true;
                        this.$events.fire('reloadStats');
                    }
                })
            },
            next: function () {
                let id = parseInt(this.id) + 1;

                this.$router.push({name: "HymnDetails", params: {id}});
            },
            prev: function () {
                if (this.id > 1) {
                    let id = parseInt(this.id) - 1;
                    this.$router.push({name: "HymnDetails", params: {id}});
                }
            }
        }
    };
</script>
