# GIS
This REPO is used for evaluating GIS features.

xml     (Simply get lat/long data from table)
jsom    (Simply get json data from public json provider)
mysql80 (Use GIS functions with MySQL8.0)

# xml

1) Simple GIS confirmation with google map.
 - geo.html (Top Page)
 - dom_marker.php (creating xml with php)
 - phpsqlajax_dbinfo.php (set db access info)
 - GIS.dump (dump for the sample table)

Reference:

https://developers.google.com/maps/documentation/javascript/mysql-to-maps?hl=ja

2) Will check GIS feature in MySQL8.0 (It works with SRID)

https://dev.mysql.com/doc/refman/8.0/en/spatial-analysis-functions.html


# mysql80

2) Simple GIS confirmation with google map. (With MySQL8.0)
 - geo.html (Top Page)
 - dom_restaurant_geo.php (creating xml with php)
 - phpsqlajax_dbinfo.php (set db access info)
 - nodes_nodetags.ZIP (dump for the sample tables)
 
select nodetags.v as 'name', st_latfromgeohash(st_geohash((nodes.geom),8)) as 'lat',
st_longfromgeohash(st_geohash((nodes.geom),8)) as 'lng','restaurant' as 'type' 
FROM nodes,nodetags WHERE nodes.id = nodetags.id and match(tags) 
against ('+restaurant' IN BOOLEAN MODE)  and nodetags.k='name' and nodes.GeoHash5 = 'xn76g' limit 20;
