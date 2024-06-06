import { Box, ListItem, ListItemText, Typography } from "@mui/material";

export default function NotificationDisplay({ notificationText, isUnread }) {
  const boldWords = [
    "eliminada.",
    "rechazada",
    "aceptada.",
    "eliminada",
    "aceptada",
  ];
  const textParts = notificationText.split(" ");

  return (
    <ListItem sx={{ minWidth: 200 }}>
      <ListItemText
        primary={textParts.map((part, index) =>
          boldWords.includes(part.toLowerCase()) ? (
            <Typography
              key={index}
              component="span"
              sx={{ fontWeight: "bold" }}
            >
              {part}{" "}
            </Typography>
          ) : (
            <Typography key={index} component="span">
              {part}{" "}
            </Typography>
          )
        )}
        sx={{ maxWidth: 300, textAlign: "justify" }}
      />
      {isUnread && (
        <Box
          sx={{
            bgcolor: "rgb(0, 123, 255)",
            width: 12,
            height: 12,
            borderRadius: "50%",
            marginLeft: 3,
          }}
        />
      )}
    </ListItem>
  );
}
