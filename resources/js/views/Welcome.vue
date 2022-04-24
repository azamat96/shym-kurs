<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Басты бет</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Жалпылама ақпараттар</li>
        </ol>
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border text-primary m-5" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else class="row">
            <!--<div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span>Primary Card</span>
                        <span class="badge bg-light text-dark rounded-pill">14</span></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="text-dark">Қазір курс оқып жатқан мұғалімдер саны</span>
                        <span class="badge bg-light text-dark rounded-pill">{{nowStudying}}</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span>Осы жылы курс аяқтаған мұғалімдер саны</span>
                        <span class="badge bg-light text-dark rounded-pill">{{thisYearDone}}</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span>Осы жылы курс оқуы қажет мұғалімдер саны</span>
                        <span class="badge bg-light text-dark rounded-pill">{{mustBeStudy}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as teacherService from '../services/teacher_service'

export default {
    name: "Welcome",
    data() {
        return {
            loading: false,
            nowStudying: null,
            thisYearDone: null,
            mustBeStudy: null
        }
    },
    mounted() {
        this.loadPage()
    },
    methods: {
        loadPage: async function() {
            this.loading = true
            try {
                const response = await teacherService.getTypesCount()
                this.nowStudying = response.data.nowStudying
                this.thisYearDone = response.data.thisYearDone
                this.mustBeStudy = response.data.mustBeStudy
            } catch (e) {
                this.$toast.error('Серверде қателіктер');
            }
            this.loading = false
        }
    }
}
</script>

<style scoped>

</style>
