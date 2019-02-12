<template>
    <div class="container-fluid mt--7">
        <div class="row mt-5">
            <div class="col-xl-9 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Hymns</h3>
                            </div>
                            <div class="col text-right">
                                <a href="#!" class="btn btn-sm btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Hymn Number</th>
                                <th scope="col">Title</th>
                                <th scope="col">Extra</th>
                                <th scope="col">More</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for='hymn in hymns'>
                                <th scope="row">
                                    {{hymn.number}}
                                </th>
                                <td>
                                    {{hymn.title}}
                                </td>
                                <td>
                                    {{hymn.extra}}
                                </td>
                                <td>
                                    <router-link :to="{ name: 'HymnDetails', params : {id : hymn.id} }">
                                        <i class="fas fa-arrow-right text-success mr-3"></i>
                                    </router-link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center" style="padding-bottom:19px;">
                         <a href="#!" class="btn btn-sm btn-primary" v-on:click= "getLatestHymns()">More <i class="fas fa-spinner" v-if="loading"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Social traffic</h3>
                            </div>
                            <div class="col text-right">
                                <a href="#!" class="btn btn-sm btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Referral</th>
                                <th scope="col">Visitors</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">
                                    Facebook
                                </th>
                                <td>
                                    1,480
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">60%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-danger" role="progressbar"
                                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: 60%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    Facebook
                                </th>
                                <td>
                                    5,480
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">70%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-success" role="progressbar"
                                                     aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: 70%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    Google
                                </th>
                                <td>
                                    4,807
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">80%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-primary" role="progressbar"
                                                     aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: 80%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    Instagram
                                </th>
                                <td>
                                    3,678
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">75%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info" role="progressbar"
                                                     aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: 75%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    twitter
                                </th>
                                <td>
                                    2,645
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">30%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-warning" role="progressbar"
                                                     aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                                                     style="width: 30%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        mounted() {
            this.$events.listen('newRecord', eventData => this.updateRecords());
            this.axios = axios.create({
                headers: {'api_token': authToken}
            });
            this.getLatestHymns();
        }, data: function () {
            return {
                message: 'Hi Bro',
                hymns: [],
                axios: null,
                page : 1,
                loading:false,
            }
        }, methods: {
            updateRecords: function () {
                this.getLatestHymns();
            },
            getLatestHymns: function () {
                this.loading = true;
                this.axios.get('/api/fetch?page='+this.page).then(response => {
                    let data = response.data.data.data;
                    let concatData = this.hymns.concat(data);
                    //console.log(concatData);
                    this.hymns = concatData;
                    this.loading = false;
                    this.page++;
                })
            },
            getHymns: function () {
                return this.hymns;
            }
        }, ready: function () {

        }
    }
</script>
