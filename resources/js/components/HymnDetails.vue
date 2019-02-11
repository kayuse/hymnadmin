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
                                <a href="#!" class="btn btn-sm btn-primary">New Verse</a>
                                <a href="#!" class="btn btn-sm btn-success">Add Chorus</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <h6 class="heading-small text-muted mb-4">Hymn information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Title</label>
                                            <input type="text" id="input-username"
                                                   v-model="hymn.title"
                                                   class="form-control form-control-alternative" placeholder="Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-first-name">Extra</label>
                                            <input type="text" id="input-first-name"
                                                   v-model="hymn.extra"
                                                   class="form-control form-control-alternative"
                                                   placeholder="First name" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-last-name">Number</label>
                                            <input type="text" id="input-last-name"
                                                   v-model="hymn.number"
                                                   class="form-control form-control-alternative" placeholder="Last name"
                                                   value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span>Verses</span>
                            <hr class="my-4"/>
                            <!-- Description -->
                            <div v-for="(verse,index) in hymn.verses">
                                <h6 class="heading-small text-muted mb-4">Verse {{index + 1}}
                                    <a v-on:click="deleteHymn(index)" class="small del" style="float: right;"><i class="fa fa-times"></i> Delete</a>
                                </h6>
                                <div class="pl-lg-4">
                                    <div class="form-group">
                                        <wysiwyg v-model="hymn.verses[index]" />
                                    </div>
                                </div>
                            </div>
                            <div class="row right--2" style="float: right;">
                                <div class="col-lg-12 right--1">
                                    <button class="btn btn-danger">Cancel</button>
                                    <button class="btn btn-facebook">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 order-lg-2 text-center">
                            <div class="card-profile-image" style="padding-top:23px;">
                                <h2>Hymn Info</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="text-center">
                            <h3>
                                E korin iyifl si Olorun<span class="font-weight-light">, Hymn Number 1</span>
                            </h3>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>Praise God fi’orn Whom All Blessings
                                FlowG.H.34
                            </div>

                            <hr class="my-4"/>
                            <p>Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs
                                and records all of his own music.</p>
                            <a href="#">Show more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang = "scss">
    @import "~vue-wysiwyg/dist/vueWysiwyg.css";
    .del:hover{
        cursor: pointer;
    }
</style>
<script>
    import axios from 'axios';
    export default {
        mounted() {
            this.$events.listen('newRecord', eventData => console.log('hi'));
            this.axios = axios.create({
                headers: {'api_token': authToken}
            });
            this.getHymn();
        }, data: function () {
            return {
                message: 'Hi Bro',
                hymn: {
                    title : "",
                    number : "",
                    extra : "",
                    chorus : "",
                    verses : []
                },
                axios: null,
                errors: [],
                status: 0,
            }
        }, methods: {
            getHymn: function () {
                let id = this.$route.params.id;
                this.axios.get('/api/get/' + id).then((response) => {
                    let data = response.data.data;
                    this.hymn.title = data.title;
                    this.hymn.extra = data.extra;
                    this.hymn.number = data.number;
                    this.processVerses(data.data);
                    console.log(data);
                }).catch((error) => {
                    this.status = 2;
                    this.errors.push("Error in processing records");
                });
            },
            processVerses: function (data) {
                let content = JSON.parse(data);
                for (let key in content) {
                    if (content.hasOwnProperty(key)) {
                        if(key.toLowerCase() == "egbe"){
                            this.hymn.chorus = content[key];
                            continue;
                        }
                        this.hymn.verses.push(content[key]);
                    }
                }
            },
            deleteHymn : function (i) {
                console.log(i);
                this.hymn.verses.splice(i,1);
            }
        }
    }
</script>
