<ul>
    <li>
        <button class="btn-primary">K</button>
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </li>
    <li></li>
    <li></li>
    <li></li>
    <li>
        <button class="btn-primary">K</button>
        <ul>
            <li>

            </li>
            <li>
                <button class="btn-primary">K</button>
                <ul>
                    <li></li>
                    <li>
                        <ul>
                            <li></li>
                            <li>
                                <ul>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </li>
</ul>
<script>
    $('li ul').addClass('collapse');
    $('li button').click(function () {
        $(this).parent('li').children('ul').collapse('toggle');
    });
</script>