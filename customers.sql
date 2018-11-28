/*Customers table nieuwe columns-*/
ALTER TABLE customers
  ADD Email varchar(64)
    AFTER PaymentDays,
  ADD Password varchar(255)
    AFTER Email,
  ADD city varchar(40)
    AFTER WebsiteURL,
  ADD Country varchar(40)
    AFTER WebsiteURL;


INSERT INTO `customercategories`(`CustomerCategoryName`, `LastEditedBy`)
VALUES ('Customer', 1);

UPDATE customercategories SET ValidFrom='2018-11-25 00:00:00', ValidTO='9999-12-31 23:59:59' WHERE CustomerCategoryID=0;


INSERT INTO stateprovinces(stateprovinceID, Stateprovincecode, stateprovincename, countryid, salesterritory, lasteditedby,validfrom,validto)
VALUES (54, 'STD', 'Standard', 153, 'External', 1, '2018-11-26 15:11:00', '9999-12-31 23:59:59')

INSERT INTO cities (CityID, CityName, StateProvinceID, LastEditedBy, ValidFrom, ValidTo)
SELECT MAX( cityid ) + 1, 'Holland City', 54, 1, '2018-11-26 00:00:00', '9999-12-31 23:59:59' FROM cities;
