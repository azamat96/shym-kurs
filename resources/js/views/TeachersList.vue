<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Мұғалімдер тізімі</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Басты бет</a></li>
            <li class="breadcrumb-item active">Мұғалімдер тізімі</li>
        </ol>
        <!--<div class="card mb-4">
            <div class="card-body">
                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                .
            </div>
        </div>-->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Мұғалімдер тізімі
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table">
                    <caption>Тізімде 100 мұғалімнің 22 көрсетілінді</caption>
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Мектеп атауы</th>
                        <th>Аты-жөні</th>
                        <th>Туған күні</th>
                        <th>Пәні</th>
                        <th>Оқыту тілі</th>
                        <th>Еңбек өтілі/стажы</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Мектеп атауы</th>
                        <th>Аты-жөні</th>
                        <th>Туған күні</th>
                        <th>Пәні</th>
                        <th>Оқыту тілі</th>
                        <th>Еңбек өтілі/стажы</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr class="table-danger">
                        <td>1</td>
                        <td>№101</td>
                        <td>Гулмира Есенали</td>
                        <td>24.06.1992</td>
                        <td>Ағылшын тілі</td>
                        <td>орыс тілінде</td>
                        <td>6 жыл</td>
                    </tr>
                    <tr class="table-danger">
                        <td>2</td>
                        <td>№9</td>
                        <td>Алмира Оразовна</td>
                        <td>7.12.1981</td>
                        <td>Орыс тілі</td>
                        <td>қазақ тілінде</td>
                        <td>11 жыл</td>
                    </tr>
                    <tr class="table-danger">
                        <td>3</td>
                        <td>№56</td>
                        <td>Айдос Миятов</td>
                        <td>28.03.1996</td>
                        <td>Дене шынықтыру</td>
                        <td>орыс тілінде</td>
                        <td>3 жыл</td>
                    </tr>
                    <tr class="table-warning">
                        <td>4</td>
                        <td>№8</td>
                        <td>Дариға Айдарова</td>
                        <td>18.12.1972</td>
                        <td>Қазақ тілі</td>
                        <td>қазақ тілінде</td>
                        <td>30 жыл</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>№204</td>
                        <td>Асан Еркінов</td>
                        <td>24.11.1992</td>
                        <td>Химия</td>
                        <td>орыс тілінде</td>
                        <td>6 жыл</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>№11</td>
                        <td>Айгүл Есенали</td>
                        <td>2.05.1992</td>
                        <td>Орыс тілі</td>
                        <td>орыс тілінде</td>
                        <td>6 жыл</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>№112</td>
                        <td>Гулмира Джуринская</td>
                        <td>2.01.1995</td>
                        <td>Ағылшын тілі</td>
                        <td>қазақ тілінде</td>
                        <td>6 жыл</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>№115</td>
                        <td>Маханбет Алиев</td>
                        <td>25.03.1985</td>
                        <td>Технология</td>
                        <td>орыс тілінде</td>
                        <td>15 жыл</td>
                    </tr>
                    <tr class="table-success">
                        <td>9</td>
                        <td>№101</td>
                        <td>Гулмира Есенали</td>
                        <td>24.12.1992</td>
                        <td>Ағылшын тілі</td>
                        <td>орыс тілінде</td>
                        <td>6 жыл</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>№10</td>
                        <td>Алибек Есиркепов</td>
                        <td>1.10.1982</td>
                        <td>Физика</td>
                        <td>қазақ тілінде</td>
                        <td>16 жыл</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>№64</td>
                        <td>Есенали Тайжанов</td>
                        <td>1.04.1991</td>
                        <td>Биология</td>
                        <td>орыс тілінде</td>
                        <td>10 жыл</td>
                    </tr>
                    <tr class="table-success">
                        <td>12</td>
                        <td>№25</td>
                        <td>Гулнур Ермекова</td>
                        <td>4.01.1987</td>
                        <td>Математика</td>
                        <td>орыс тілінде</td>
                        <td>12 жыл</td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td>№65</td>
                        <td>Газиза Галиев</td>
                        <td>2.02.1992</td>
                        <td>Ағылшын тілі</td>
                        <td>орыс тілінде</td>
                        <td>10 жыл</td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td>№11</td>
                        <td>Берик Сарсенович</td>
                        <td>5.01.1997</td>
                        <td>Тарих</td>
                        <td>қазақ тілінде</td>
                        <td>2 жыл</td>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td>№34</td>
                        <td>Уали Берык</td>
                        <td>24.12.1990</td>
                        <td>Дене шынықтыру</td>
                        <td>орыс тілінде</td>
                        <td>9 жыл</td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td>№12</td>
                        <td>Ольга Карапетян</td>
                        <td>22.07.1989</td>
                        <td>Ағылшын тілі</td>
                        <td>орыс тілінде</td>
                        <td>15 жыл</td>
                    </tr>
                    <tr>
                        <td>17</td>
                        <td>№27</td>
                        <td>Алена Никольская</td>
                        <td>1.12.1995</td>
                        <td>Орыс тілі</td>
                        <td>орыс тілінде</td>
                        <td>4 жыл</td>
                    </tr>
                    <tr>
                        <td>18</td>
                        <td>№92</td>
                        <td>Азамат Айбергенов</td>
                        <td>24.12.1996</td>
                        <td>Қазақ тілі</td>
                        <td>қазақ тілінде</td>
                        <td>5 жыл</td>
                    </tr>
                    <tr>
                        <td>19</td>
                        <td>№100</td>
                        <td>Назира Ерболатовна</td>
                        <td>27.12.1979</td>
                        <td>Биология</td>
                        <td>орыс тілінде</td>
                        <td>20 жыл</td>
                    </tr>
                    <tr>
                        <td>20</td>
                        <td>№98</td>
                        <td>Руслан Берденов</td>
                        <td>6.06.1986</td>
                        <td>Химия</td>
                        <td>орыс тілінде</td>
                        <td>12 жыл</td>
                    </tr>
                    <tr>
                        <td>21</td>
                        <td>№204</td>
                        <td>Нарикби Есенали</td>
                        <td>2.02.1995</td>
                        <td>Информатика</td>
                        <td>орыс тілінде</td>
                        <td>7 жыл</td>
                    </tr>
                    <tr>
                        <td>22</td>
                        <td>№102</td>
                        <td>Айдар Алиев</td>
                        <td>24.12.1992</td>
                        <td>Ағылшын тілі</td>
                        <td>орыс тілінде</td>
                        <td>6 жыл</td>
                    </tr>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Артқа</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Алға</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TeachersList"
}
</script>

<style scoped>

</style>
