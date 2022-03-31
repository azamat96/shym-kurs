<template>
    <div>
        <table class="table table-bordered">
            <caption>Тізімде бүкіл активты курстар</caption>
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Курс атауы</th>
                <th>Толық ақпарат</th>
                <th>2022</th>
                <th>2021</th>
                <th>2019 жане оған дейін</th>
                <th><i class="fas fa-cog"></i> Қызмет түрлері</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(course, index) in coursesList" :key="index">
                <td>{{ index+1 }}</td>
                <td>{{ course.name }}</td>
                <td>{{ course.description }}</td>
                <td>106</td>
                <td>505</td>
                <td>505</td>
                <td>
                    <button v-on:click="editCourse(course)" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Өзгерту"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-secondary btn-sm"><i class="fas fa-power-off"></i> Архивтау</button>
                    <button v-on:click="deleteCourse(course)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Өшіру"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
        <!-- Modal for edit course -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="editCourseModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form v-on:submit.prevent="updateCourse()">
                        <div class="modal-header">
                            <h5 class="flex-fill modal-title text-center" id="editModalLabel">Курсты өзгерту</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Курс атауы</label>
                                <input v-model="editCourseData.name" v-bind:class="{'is-invalid': errors.name}" type="text" class="form-control" aria-describedby="emailHelp" required>
                                <div class="invalid-feedback" v-if="errors.name" v-bind:class="{'d-block': errors.name}">{{ errors.name[0] }}</div>
                                <div class="form-text" v-else>Басқа курс атаумен бірдей болмағаны жөн</div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Толық ақпарат</label>
                                <textarea v-model="editCourseData.description" class="form-control" rows="3"></textarea>
                                <div class="form-text">Бос қалдыруға болады</div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Жабу</button>
                            <button type="submit" class="btn btn-primary">
                                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span v-else><i class="fas fa-check-circle"></i></span> Курсты өзгерту
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ActiveCourses",
    data() {
        return {
            coursesList: [],
            editCourseData: {},
            errors: {},
            toast: {
                ok: null,
                err: null
            },
            loading: false,
            editCourseModal: null
        }
    },
}
</script>

<style scoped>

</style>
