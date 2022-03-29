<template>
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mt-4">Курстар тізімі</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fas fa-plus-circle"></i> Жаңа курс қосу
            </button>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Басты бет</a></li>
            <li class="breadcrumb-item active">Курстар тізімі</li>
        </ol>
        <ul class="nav nav-pills" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Активный курстар</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Архивный курстар</button>
            </li>
        </ul>
        <div class="tab-content mb-4 mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-bordered">
                    <caption>Тізімде бүкіл активты курстар</caption>
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Курс атауы</th>
                        <th>2022</th>
                        <th>2021</th>
                        <th>2020-ға дейін</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Жаңартылған</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Әдістемелік</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Пән аралық</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Жаңартылған</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-bordered">
                    <caption>Тізімде бүкіл архивты курстар</caption>
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Курс атауы</th>
                        <th>2022</th>
                        <th>2021</th>
                        <th>2020-ға дейін</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Жаңартылған</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Әдістемелік</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Пән аралық</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Жаңартылған</td>
                        <td>56</td>
                        <td>106</td>
                        <td>505</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form v-on:submit.prevent="CreateCourse">
                    <div class="modal-header">
                        <h5 class="flex-fill modal-title text-center" id="exampleModalLabel">Жаңа курс қосу</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Курс атауы</label>
                            <input v-model="newCourse.name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Басқа курс атаумен бірдей болмағаны жөн</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Толық ақпарат</label>
                            <textarea v-model="newCourse.description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            <div id="textHelp" class="form-text">Бос қалдыруға болады</div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Жабу</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Курсты Қосу</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CoursesList",
    data() {
        return {
            newCourse: {
                name: '',
                description: ''
            }
        }
    },
    methods: {
        CreateCourse() {
            console.log('form submitted')
        }
    }
}
</script>

<style scoped>

</style>
