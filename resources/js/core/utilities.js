export function updateValue(updateObject) {
  this[updateObject.name] = updateObject.value;
}