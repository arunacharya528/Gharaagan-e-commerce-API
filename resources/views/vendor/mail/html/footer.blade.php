<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="content-cell" align="center">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
            <tr>
                <td style="width: 100%; padding:1rem 0;">
                    @php
                        $socialLinks = App\Models\SiteDetail::where('name', 'social_links')->first()->value;
                        $socialLinks = json_decode($socialLinks, true);
                    @endphp

                    @foreach ($socialLinks as $link)
                        <a href="{{$link['path']}}" target="_blank" >{{$link['path']}}</a>
                    @endforeach
                </td>
            </tr>
        </table>
    </td>
</tr>
