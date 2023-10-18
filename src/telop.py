# https://www.nhk.or.jp/kishou-saigai/about/
# https://www.nhk.or.jp/kishou-saigai/static/assets/telop_103.svg

telop = ["Unknown ({idx})" for idx in range(1 << 9)]

telop[100] = "晴れ"
telop[101] = "晴れ時々くもり"
telop[102] = "晴れ一時雨"
telop[103] = "晴れ時々雨"
telop[111] = "晴れのちくもり"
telop[114] = "晴れのち雨"
telop[200] = "くもり"
telop[201] = "くもり時々晴れ"
telop[202] = "くもり一時雨"
telop[203] = "くもり時々雨"
telop[211] = "くもりのち晴れ"
telop[214] = "くもりのち雨"
telop[300] = "雨"
telop[301] = "雨時々晴れ"
telop[302] = "雨一時くもり"
telop[303] = "雨時々雪"
telop[311] = "雨のち晴れ"
telop[313] = "雨のちくもり"
telop[315] = "雨のち雪"
telop[400] = "雪"
telop[401] = "雪時々晴れ"
telop[402] = "雪時々やむ"
telop[403] = "雪時々雨"
telop[411] = "雪のち晴れ"
telop[413] = "雪のちくもり"
telop[414] = "雪のち雨"
