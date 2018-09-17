ALTER TABLE posts
  ADD COLUMN `event_date` DATE GENERATED ALWAYS
AS (CAST(meta->>"$.event.date" AS DATE)) VIRTUAL;