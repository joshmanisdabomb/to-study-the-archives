<?php

return json_decode(file_get_contents(resource_path("lang/en_us/lcc.json")), true) + json_decode(file_get_contents(resource_path("lang/en_us/minecraft.json")), true);
