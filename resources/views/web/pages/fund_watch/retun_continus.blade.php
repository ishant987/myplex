<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th class="green_bg">Return</th>
            <th class="dark_bg">6 M</th>
            <th class="dark_bg">1 Y</th>
            <th class="dark_bg">2 Y</th>
            <th class="dark_bg">3 Y</th>
            <th class="dark_bg">5 Y</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-label="Return">Benchmark</td>
            <td data-label="6M">{{round($bench_mark['SIXMONTHS'],2)}}</td>
            <td data-label="1Y">{{round($bench_mark['ONEYEAR'],2)}}</td>
            <td data-label="2Y">{{round($bench_mark['TWOYEAR'],2)}}</td>
            <td data-label="3Y">{{round($bench_mark['THREEYEAR'],2)}}</td>
            <td data-label="5Y">{{round($bench_mark['FIVEYEAR'],2)}}</td>
        </tr>
        <tr>
            <td data-label="Return">Scheme</td>
            <td data-label="6M">{{round($scheme['SIXMONTHS'],2)}}</td>
            <td data-label="1Y">{{round($scheme['ONEYEAR'],2)}}</td>
            <td data-label="2Y">{{round($scheme['TWOYEAR'],2)}}</td>
            <td data-label="3Y">{{round($scheme['THREEYEAR'],2)}}</td>
            <td data-label="5Y">{{round($scheme['FIVEYEAR'],2)}}</td>
        </tr>
        <tr>
            <td data-label="Return">Category AV</td>
            <td data-label="6M">{{round($category_average['SIXMONTHS']['category_avg'],2)}}</td>
            <td data-label="1Y">{{round($category_average['ONEYEAR']['category_avg'],2)}}</td>
            <td data-label="2Y">{{round($category_average['TWOYEAR']['category_avg'],2)}}</td>
            <td data-label="3Y">{{round($category_average['THREEYEAR']['category_avg'],2)}}</td>
            <td data-label="5Y">{{round($category_average['FIVEYEAR']['category_avg'],2)}}</td>
        </tr>

    </tbody>
</table>