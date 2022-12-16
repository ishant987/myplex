<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th class="dark_bg">Equity</th>
            <th class="dark_bg">Debt</th>
            <th class="dark_bg">SOV</th>
            <th class="dark_bg">Cash</th>
            <th class="dark_bg">Other Cuurency</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-label="Scripe">{{ $PortFoliBreakup['Equity'] }}</td>
            <td data-label="Debt">{{ $PortFoliBreakup['Corporate Debt'] }}
            </td>
            <td data-label="SOV">{{ $PortFoliBreakup['SOV'] }}</td>
            <td data-label="Cash">{{ $PortFoliBreakup['Cash'] }}</td>
            <td data-label="Other Cuurency">
                {{ $PortFoliBreakup['Others'] }}</td>
        </tr>
    </tbody>
</table>