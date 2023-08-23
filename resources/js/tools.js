
export const arrayOfObjectsToMap = (array) => {
  const mapOfObjects = new Map()

  if (array.length == 0) {
    return mapOfObjects
  }

  array.forEach(obj => {
    mapOfObjects.set(obj.id, obj);
  });

  return mapOfObjects
}