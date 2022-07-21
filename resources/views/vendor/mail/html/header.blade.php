<tr>
    <td class="header">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="header">
                    <img src="{{ App\Models\SiteDetail::where('name', 'logo_url')->first()->value }}" style="width:auto"
                        alt="Gharagan logo" />
                    <a href="{{ env('CLIENT_SITE_ADDRESS') }}" style="display: inline-block;">
                        {{ $slot }}
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>
